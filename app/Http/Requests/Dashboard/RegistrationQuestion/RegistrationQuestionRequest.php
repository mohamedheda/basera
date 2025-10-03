<?php

namespace App\Http\Requests\Dashboard\RegistrationQuestion;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_text_en' => 'required|string|max:500',
            'question_text_ar' => 'required|string|max:500',
            'question_type' => 'required|in:text,number,date,select,radio,checkbox,textarea',
            'options_en' => 'nullable|string',
            'options_ar' => 'nullable|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
            'validation_rules' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'question_text_en.required' => __('validation.required', ['attribute' => __('messages.Question Text (English)')]),
            'question_text_ar.required' => __('validation.required', ['attribute' => __('messages.Question Text (Arabic)')]),
            'question_type.required' => __('validation.required', ['attribute' => __('messages.Question Type')]),
            'order.required' => __('validation.required', ['attribute' => __('messages.Order')]),
        ];
    }
}
