<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionWithAnswerResource extends JsonResource
{
    protected $userAnswer;

    public function __construct($resource, $userAnswer = null)
    {
        parent::__construct($resource);
        $this->userAnswer = $userAnswer;
    }

    public function toArray(Request $request): array
    {
        $answer = $this->userAnswer;

        if ($this->question_type === 'checkbox' && is_string($answer)) {
            $answer = json_decode($answer, true);
        }

        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'question_text_en' => $this->question_text_en,
            'question_text_ar' => $this->question_text_ar,
            'question_type' => $this->question_type,
            'options' => $this->options,
            'is_required' => $this->is_required,
            'order' => $this->order,
            'validation_rules' => $this->validation_rules,
            'user_answer' => $answer,
        ];
    }
}
