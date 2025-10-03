<?php

namespace App\Http\Requests\Dashboard\SubscriptionPackage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionPackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $packageId = $this->route('subscription_package');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('subscription_packages', 'name')->ignore($packageId)],
            'description' => 'nullable|string',
            'duration_type' => 'required|in:monthly,semi_annual,annual',
            'duration_months' => 'required|integer|min:1|max:24',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'features.*' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('dashboard.Package Name')]),
            'name.unique' => __('validation.unique', ['attribute' => __('dashboard.Package Name')]),
            'duration_type.required' => __('validation.required', ['attribute' => __('dashboard.Duration Type')]),
            'duration_type.in' => __('validation.in', ['attribute' => __('dashboard.Duration Type')]),
            'duration_months.required' => __('validation.required', ['attribute' => __('dashboard.Duration (Months)')]),
            'duration_months.integer' => __('validation.integer', ['attribute' => __('dashboard.Duration (Months)')]),
            'price.required' => __('validation.required', ['attribute' => __('dashboard.Price')]),
            'price.numeric' => __('validation.numeric', ['attribute' => __('dashboard.Price')]),
            'currency.required' => __('validation.required', ['attribute' => __('dashboard.Currency')]),
        ];
    }
}
