<?php

namespace App\Http\Requests\Dashboard\InvestmentOpportunity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvestmentOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $opportunityId = $this->route('investment_opportunity');

        return [
            'company_name' => ['required', 'string', 'max:255', Rule::unique('investment_opportunities', 'company_name')->ignore($opportunityId)],
            'description' => 'required|string',
            'current_price' => 'required|numeric|min:0',
            'entry_price' => 'required|numeric|min:0',
            'expected_return_percentage' => 'required|numeric|min:0|max:100',
            'market' => 'required|in:saudi,american,global',
            'sector' => 'required|in:energy,banking,technology,healthcare,real_estate',
            'is_halal' => 'boolean',
            'risk_level' => 'required|in:low,medium,high',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => __('validation.required', ['attribute' => __('dashboard.Company Name')]),
            'company_name.unique' => __('validation.unique', ['attribute' => __('dashboard.Company Name')]),
            'description.required' => __('validation.required', ['attribute' => __('dashboard.Description')]),
            'current_price.required' => __('validation.required', ['attribute' => __('dashboard.Current Price')]),
            'entry_price.required' => __('validation.required', ['attribute' => __('dashboard.Entry Price')]),
            'expected_return_percentage.required' => __('validation.required', ['attribute' => __('dashboard.Expected Return')]),
            'market.required' => __('validation.required', ['attribute' => __('dashboard.Market')]),
            'market.in' => __('validation.in', ['attribute' => __('dashboard.Market')]),
            'sector.required' => __('validation.required', ['attribute' => __('dashboard.Sector')]),
            'sector.in' => __('validation.in', ['attribute' => __('dashboard.Sector')]),
            'risk_level.required' => __('validation.required', ['attribute' => __('dashboard.Risk Level')]),
            'risk_level.in' => __('validation.in', ['attribute' => __('dashboard.Risk Level')]),
            'image.image' => __('validation.image', ['attribute' => __('dashboard.Image')]),
            'image.max' => __('validation.max.file', ['attribute' => __('dashboard.Image'), 'max' => '2048']),
        ];
    }
}
