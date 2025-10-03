<?php

namespace App\Http\Requests\Dashboard\Bank;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bankId = $this->route('bank');

        return [
            'name_en' => ['required', 'string', 'max:255', Rule::unique('banks', 'name_en')->ignore($bankId)],
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('banks', 'name_ar')->ignore($bankId)],
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' => __('validation.required', ['attribute' => __('messages.Bank Name (English)')]),
            'name_en.unique' => __('validation.unique', ['attribute' => __('messages.Bank Name (English)')]),
            'name_ar.required' => __('validation.required', ['attribute' => __('messages.Bank Name (Arabic)')]),
            'name_ar.unique' => __('validation.unique', ['attribute' => __('messages.Bank Name (Arabic)')]),
        ];
    }
}
