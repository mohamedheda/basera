<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['required', 'string', Rule::unique('users', 'phone')],
            'password' => ['required', 'string', 'min:8'],
            'id_number' => ['required', 'string', Rule::unique('users', 'id_number')],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'family_members_count' => ['required', 'integer', 'min:1'],
            'education_level' => ['required', 'in:high_school,diploma,bachelor,master,phd'],
            'annual_income' => ['required', 'numeric', 'min:0'],
            'total_savings' => ['required', 'numeric', 'min:0'],
            'bank_id' => ['required', 'exists:banks,id'],
            'has_investment_experience' => ['required', 'boolean'],
            'willing_to_risk_capital' => ['required', 'boolean'],
            'has_stable_income' => ['required', 'boolean'],
            'plans_short_term_withdrawal' => ['required', 'boolean'],
            'prefers_high_risk_high_return' => ['required', 'boolean'],
            'consults_financial_advisor' => ['required', 'boolean'],
        ];
    }
}
