@extends('dashboard.core.app')
@section('title', __('dashboard.users'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- BreadCrumb -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.users') }}" :breadcrumbs="[['name' => __('dashboard.users'), 'route' => 'users.index'], ['name' => __('dashboard.Create')]]" />
        <!-- BreadCrumb -->

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>
            <x-form.form-component :route="route('users.store')" method="POST">
                <!-- Basic Information -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">@lang('dashboard.Contact Information :')</h5>
                    </div>
                </div>

                <x-input.input-field name="name" label="{{ __('dashboard.Name') }}"
                    placeholder="{{ __('dashboard.Name') }}" class="custom-class" id="nameInput" required="true" />

                <x-input.input-field name="email" type="email" label="{{ __('dashboard.Email') }}"
                    placeholder="{{ __('dashboard.Email') }}" />

                <x-input.input-field name="phone" label="{{ __('dashboard.Phone') }}"
                    placeholder="{{ __('dashboard.Phone') }}" required="true" />

                <x-input.input-field name="national_id" label="{{ __('dashboard.National ID') }}"
                    placeholder="{{ __('dashboard.Enter national ID') }}" />

                <x-input.input-field name="password" type="password" label="{{ __('dashboard.password') }}"
                    placeholder="{{ __('dashboard.password') }}" required="true" />

                <x-input.input-field name="password_confirmation" type="password"
                    label="{{ __('dashboard.password_confirmation') }}"
                    placeholder="{{ __('dashboard.password_confirmation') }}" required="true" />

                <!-- Personal Information -->
                <div class="row mb-3 mt-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">@lang('dashboard.Personal Information')</h5>
                    </div>
                </div>

                <x-input.input-field name="date_of_birth" type="date" label="{{ __('dashboard.Date of Birth') }}"
                    placeholder="{{ __('dashboard.Date of Birth') }}" />

                <div class="mb-3">
                    <label class="form-label">@lang('dashboard.Marital Status')</label>
                    <select name="marital_status" class="form-control">
                        <option value="">@lang('dashboard.Select Marital Status')</option>
                        <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>@lang('dashboard.Single')
                        </option>
                        <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                            @lang('dashboard.Married')</option>
                        <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>
                            @lang('dashboard.Divorced')</option>
                        <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>
                            @lang('dashboard.Widowed')</option>
                    </select>
                </div>

                <x-input.input-field name="family_members_count" type="number"
                    label="{{ __('dashboard.Family Members Count') }}"
                    placeholder="{{ __('dashboard.Enter family members count') }}" />

                <div class="mb-3">
                    <label class="form-label">@lang('dashboard.Education Level')</label>
                    <select name="education_level" class="form-control">
                        <option value="">@lang('dashboard.Select Education Level')</option>
                        <option value="high_school" {{ old('education_level') == 'high_school' ? 'selected' : '' }}>
                            @lang('dashboard.High School')</option>
                        <option value="bachelor" {{ old('education_level') == 'bachelor' ? 'selected' : '' }}>
                            @lang('dashboard.Bachelor')</option>
                        <option value="master" {{ old('education_level') == 'master' ? 'selected' : '' }}>
                            @lang('dashboard.Master')</option>
                        <option value="phd" {{ old('education_level') == 'phd' ? 'selected' : '' }}>@lang('dashboard.PhD')
                        </option>
                        <option value="other" {{ old('education_level') == 'other' ? 'selected' : '' }}>@lang('dashboard.Other')
                        </option>
                    </select>
                </div>

                <!-- Financial Information -->
                <div class="row mb-3 mt-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">@lang('dashboard.Financial Information')</h5>
                    </div>
                </div>

                <x-input.input-field name="annual_income" type="number" step="0.01"
                    label="{{ __('dashboard.Annual Income') }}" placeholder="{{ __('dashboard.Enter annual income') }}" />

                <x-input.input-field name="total_savings" type="number" step="0.01"
                    label="{{ __('dashboard.Total Savings') }}" placeholder="{{ __('dashboard.Enter total savings') }}" />

                <div class="mb-3">
                    <label class="form-label">@lang('dashboard.Bank')</label>
                    <select name="bank_id" class="form-control">
                        <option value="">@lang('dashboard.Select Bank')</option>
                        @foreach (\App\Models\Bank::active()->get() as $bank)
                            <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Account Status -->
                <div class="row mb-3 mt-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">@lang('dashboard.Account Status')</h5>
                    </div>
                </div>

                <!-- Registration Questions -->
                @php
                    $questions = \App\Models\RegistrationQuestion::active()->get();
                @endphp
                @if ($questions->count() > 0)
                    <div class="row mb-3 mt-4">
                        <div class="col-12">
                            <h5 class="mb-3 text-primary">@lang('dashboard.Registration Questions')</h5>
                            <p class="text-muted small">@lang('dashboard.Questions are True/False type only')</p>
                        </div>
                    </div>

                    @foreach ($questions as $question)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="ri-question-line me-2"></i>
                                {{ $question->question_text }}
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="registration_answers[{{ $question->id }}]" id="q{{ $question->id }}_true"
                                        value="true"
                                        {{ old('registration_answers.' . $question->id) == 'true' ? 'checked' : '' }}>
                                    <label class="form-check-label text-success" for="q{{ $question->id }}_true">
                                        <i class="ri-check-line me-1"></i>@lang('dashboard.True')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="registration_answers[{{ $question->id }}]" id="q{{ $question->id }}_false"
                                        value="false"
                                        {{ old('registration_answers.' . $question->id) == 'false' ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger" for="q{{ $question->id }}_false">
                                        <i class="ri-close-line me-1"></i>@lang('dashboard.False')
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </x-form.form-component>
        </x-cards.page-card>
        <!-- Page Card -->

    </div>
@endsection
