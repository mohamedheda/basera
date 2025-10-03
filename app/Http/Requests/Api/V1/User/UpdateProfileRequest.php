<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth('api')->id();

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['sometimes', 'required', 'string', Rule::unique('users', 'phone')->ignore($userId)],
            'id_number' => ['sometimes', 'required', 'string', Rule::unique('users', 'id_number')->ignore($userId)],
            'date_of_birth' => ['sometimes', 'required', 'date', 'before:today'],
            'marital_status' => ['sometimes', 'required', 'in:single,married,divorced,widowed'],
            'family_members_count' => ['sometimes', 'required', 'integer', 'min:1'],
            'education_level' => ['sometimes', 'required', 'in:high_school,diploma,bachelor,master,phd'],
            'annual_income' => ['sometimes', 'required', 'numeric', 'min:0'],
            'total_savings' => ['sometimes', 'required', 'numeric', 'min:0'],
            'bank_id' => ['sometimes', 'required', 'exists:banks,id'],
        ];
    }
}
