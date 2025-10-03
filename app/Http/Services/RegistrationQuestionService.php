<?php

namespace App\Http\Services;

use App\Models\RegistrationQuestion;
use App\Models\UserRegistrationAnswer;
use App\Models\User;
use App\Http\Resources\V1\Question\RegistrationQuestionResource;
use App\Http\Resources\UserRegistrationAnswerResource;
use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\responseFail;
use App\Http\Helpers\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrationQuestionService
{
    public function getActiveQuestions()
    {
        try {
            $questions = RegistrationQuestion::active()
                ->ordered()
                ->get();

            return responseSuccess(message: __('messages.Questions retrieved successfully'), data: RegistrationQuestionResource::collection($questions));
        } catch (\Exception $e) {
            return responseFail(status: Http::INTERNAL_SERVER_ERROR, message: __('messages.Failed to retrieve questions'), data: $e->getMessage());
        }
    }
    public function saveUserAnswers(User $user, array $answers)
    {
        DB::beginTransaction();
        try {
            foreach ($answers as $answer) {
                $question = RegistrationQuestion::find($answer['question_id']);

                if (!$question) {
                    throw new \Exception(__('messages.Question not found'));
                }

                $this->validateAnswer($question, $answer['answer']);

                UserRegistrationAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $answer['question_id'],
                    ],
                    [
                        'answer' => is_array($answer['answer'])
                            ? json_encode($answer['answer'])
                            : $answer['answer'],
                    ]
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function validateAnswer(RegistrationQuestion $question, $answer)
    {
        if ($question->is_required && empty($answer)) {
            throw new \Exception(__('messages.Answer is required for this question'));
        }

        if ($question->validation_rules) {
            $rules = explode('|', $question->validation_rules);
            $validator = Validator::make(
                ['answer' => $answer],
                ['answer' => $rules]
            );

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }
        }

        return true;
    }

    public function getUserAnswers(User $user)
    {
        $answers = UserRegistrationAnswer::where('user_id', $user->id)
            ->with('question')
            ->get();

        return UserRegistrationAnswerResource::collection($answers);
    }

    public function hasCompletedRequiredQuestions(User $user)
    {
        $requiredQuestionsCount = RegistrationQuestion::active()
            ->where('is_required', true)
            ->count();

        $userAnswersCount = UserRegistrationAnswer::where('user_id', $user->id)
            ->whereHas('question', function ($query) {
                $query->active()->where('is_required', true);
            })
            ->count();

        return $requiredQuestionsCount === $userAnswersCount;
    }

    public function getQuestionsWithUserAnswers(User $user)
    {
        $questions = RegistrationQuestion::active()
            ->ordered()
            ->get();

        $userAnswers = UserRegistrationAnswer::where('user_id', $user->id)
            ->pluck('answer', 'question_id');

        return $questions->map(function ($question) use ($userAnswers) {
            return new QuestionWithAnswerResource(
                $question,
                $userAnswers[$question->id] ?? null
            );
        });
    }
}
