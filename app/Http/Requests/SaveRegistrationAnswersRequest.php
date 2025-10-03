<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRegistrationAnswersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:registration_questions,id',
            'answers.*.answer' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'answers.required' => __('validation.required', ['attribute' => __('messages.Answers')]),
            'answers.array' => __('validation.array', ['attribute' => __('messages.Answers')]),
            'answers.min' => __('messages.At least one answer is required'),
            'answers.*.question_id.required' => __('messages.Question ID is required for each answer'),
            'answers.*.question_id.exists' => __('messages.Invalid question ID provided'),
            'answers.*.answer.required' => __('messages.Answer is required for each question'),
        ];
    }
}
