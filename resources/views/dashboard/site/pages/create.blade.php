@extends('dashboard.core.app')
@section('title', __('dashboard.Pages'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Pages') }}" :breadcrumbs="[['name' => __('dashboard.Pages'), 'route' => 'pages.index'], ['name' => __('dashboard.Create')]]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create') @lang('dashboard.Page')
                </div>
            </x-slot>
            <x-form.form-component :route="route('pages.store')" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <x-input.input-field name="slug" label="{{ __('dashboard.Slug') }}"
                            placeholder="{{ __('dashboard.Enter page slug (e.g., about-us, terms-and-conditions)') }}"
                            required="true" />
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="title_en" label="{{ __('dashboard.Title (English)') }}"
                            placeholder="{{ __('dashboard.Enter page title in English') }}" required="true" />
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="title_ar" label="{{ __('dashboard.Title (Arabic)') }}"
                            placeholder="{{ __('dashboard.Enter page title in Arabic') }}" required="true" />
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description_en" class="form-label">{{ __('dashboard.Description (English)') }} <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" name="description_en" id="description_en" rows="5"
                                placeholder="{{ __('dashboard.Enter page description in English') }}" required></textarea>
                            @error('description_en')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description_ar" class="form-label">{{ __('dashboard.Description (Arabic)') }} <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" name="description_ar" id="description_ar" rows="5"
                                placeholder="{{ __('dashboard.Enter page description in Arabic') }}" required></textarea>
                            @error('description_ar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                checked>
                            <label class="form-check-label" for="is_active">
                                @lang('dashboard.Is Active?')
                            </label>
                        </div>
                    </div>
                </div>
            </x-form.form-component>
        </x-cards.page-card>
    </div>
@endsection
