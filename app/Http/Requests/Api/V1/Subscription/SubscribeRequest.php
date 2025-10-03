<?php

namespace App\Http\Requests\Api\V1\Subscription;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @method \App\Models\User|null user($guard = null)
 */
class SubscribeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'package_id' => 'required|exists:subscription_packages,id',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'package_id.required' => 'Package ID is required',
            'package_id.exists' => 'Selected package does not exist',
            'payment_method.required' => 'Payment method is required',
            'payment_method.string' => 'Payment method must be a string',
            'payment_method.max' => 'Payment method must not exceed 255 characters',
            'transaction_id.string' => 'Transaction ID must be a string',
            'transaction_id.max' => 'Transaction ID must not exceed 255 characters',
        ];
    }
}
