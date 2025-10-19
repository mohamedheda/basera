<?php

namespace App\Http\Requests\Dashboard\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('page');

        return [
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($pageId)],
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => __('validation.required', ['attribute' => __('messages.Slug')]),
            'slug.unique' => __('validation.unique', ['attribute' => __('messages.Slug')]),
            'title_en.required' => __('validation.required', ['attribute' => __('messages.Title (English)')]),
            'title_ar.required' => __('validation.required', ['attribute' => __('messages.Title (Arabic)')]),
            'description_en.required' => __('validation.required', ['attribute' => __('messages.Description (English)')]),
            'description_ar.required' => __('validation.required', ['attribute' => __('messages.Description (Arabic)')]),
        ];
    }
}
