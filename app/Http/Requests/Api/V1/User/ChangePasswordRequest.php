<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => __('validation.required', ['attribute' => __('messages.Current Password')]),
            'new_password.required' => __('validation.required', ['attribute' => __('messages.New Password')]),
            'new_password.min' => __('validation.min.string', ['attribute' => __('messages.New Password'), 'min' => 8]),
            'new_password.confirmed' => __('validation.confirmed', ['attribute' => __('messages.New Password')]),
        ];
    }
}
