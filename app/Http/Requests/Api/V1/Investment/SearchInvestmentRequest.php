<?php

namespace App\Http\Requests\Api\V1\Investment;

use Illuminate\Foundation\Http\FormRequest;

class SearchInvestmentRequest extends FormRequest
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
            'query' => 'required|string|min:2|max:255',
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
            'query.required' => 'Search query is required',
            'query.string' => 'Search query must be a string',
            'query.min' => 'Search query must be at least 2 characters',
            'query.max' => 'Search query must not exceed 255 characters',
        ];
    }
}
