@extends('dashboard.core.app')
@section('title', __('Registration Questions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- BreadCrumb -->
        <x-breadcrumb.breadcrumb title="Registration Questions" :breadcrumbs="[
            ['name' => 'Registration Questions', 'route' => 'registration-questions.index'],
            ['name' => __('dashboard.Edit')],
        ]" />
        <!-- BreadCrumb -->

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Edit') Question
                </div>
            </x-slot>
            <x-form.form-component :route="route('registration-questions.update', $question->id)" method="PUT">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <strong>@lang('dashboard.Note'):</strong> @lang('dashboard.Questions are True/False type only')
                        </div>
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="question_text_en" label="@lang('dashboard.Question') (@lang('dashboard.en'))"
                            placeholder="Enter question in English" required="true"
                            value="{{ $question->question_text_en }}" />
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="question_text_ar" label="@lang('dashboard.Question') (@lang('dashboard.ar'))"
                            placeholder="أدخل السؤال بالعربية" required="true" value="{{ $question->question_text_ar }}" />
                    </div>

                    <div class="col-md-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                {{ $question->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                @lang('dashboard.Is Active?')
                            </label>
                        </div>
                    </div>
                </div>
            </x-form.form-component>
        </x-cards.page-card>
        <!-- Page Card -->
    </div>
@endsection
