@extends('dashboard.core.app')
@section('title', __('dashboard.users'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.users') }}" :breadcrumbs="[['name' => __('dashboard.users'), 'route' => 'users.index'], ['name' => __('dashboard.Edit')]]" />

        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>

            <x-form.form-component :route="route('users.update', $user->id)" method="PUT">
                <!-- Basic Information -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">@lang('dashboard.Contact Information :')</h5>
                    </div>
                </div>

                <x-input.input-field name="name" label="{{ __('dashboard.Name') }}"
                    placeholder="{{ __('dashboard.Name') }}" value="{{ $user->name }}" required="true" />

                <x-input.input-field name="email" type="email" label="{{ __('dashboard.Email') }}"
                    placeholder="{{ __('dashboard.Email') }}" value="{{ $user->email }}" />

                <x-input.input-field name="phone" label="{{ __('dashboard.Phone') }}"
                    placeholder="{{ __('dashboard.Phone') }}" value="{{ $user->phone }}" required="true" />

                <x-input.input-field name="national_id" label="{{ __('dashboard.National ID') }}"
                    placeholder="{{ __('dashboard.Enter national ID') }}" value="{{ $user->national_id }}" />

                <x-input.input-field name="password" type="password" label="{{ __('dashboard.password') }}"
                    placeholder="{{ __('dashboard.Optional if you dont want to change it') }}" />

                <x-input.input-field name="password_confirmation" type="password"
                    label="{{ __('dashboard.password_confirmation') }}"
                    placeholder="{{ __('dashboard.password_confirmation') }}" />

                <!-- Personal Information -->
                <div class="row mb-3 mt-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">@lang('dashboard.Personal Information')</h5>
                    </div>
                </div>

                <x-input.input-field name="date_of_birth" type="date" label="{{ __('dashboard.Date of Birth') }}"
                    placeholder="{{ __('dashboard.Date of Birth') }}"
                    value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}" />

                <div class="mb-3">
                    <label class="form-label">@lang('dashboard.Marital Status')</label>
                    <select name="marital_status" class="form-control">
                        <option value="">@lang('dashboard.Select Marital Status')</option>
                        <option value="single" {{ $user->marital_status == 'single' ? 'selected' : '' }}>@lang('dashboard.Single')
                        </option>
                        <option value="married" {{ $user->marital_status == 'married' ? 'selected' : '' }}>
                            @lang('dashboard.Married')</option>
                        <option value="divorced" {{ $user->marital_status == 'divorced' ? 'selected' : '' }}>
                            @lang('dashboard.Divorced')</option>
                        <option value="widowed" {{ $user->marital_status == 'widowed' ? 'selected' : '' }}>
                            @lang('dashboard.Widowed')</option>
                    </select>
                </div>

                <x-input.input-field name="family_members_count" type="number"
                    label="{{ __('dashboard.Family Members Count') }}"
                    placeholder="{{ __('dashboard.Enter family members count') }}"
                    value="{{ $user->family_members_count }}" />

                <div class="mb-3">
                    <label class="form-label">@lang('dashboard.Education Level')</label>
                    <select name="education_level" class="form-control">
                        <option value="">@lang('dashboard.Select Education Level')</option>
                        <option value="high_school" {{ $user->education_level == 'high_school' ? 'selected' : '' }}>
                            @lang('dashboard.High School')</option>
                        <option value="bachelor" {{ $user->education_level == 'bachelor' ? 'selected' : '' }}>
                            @lang('dashboard.Bachelor')</option>
                        <option value="master" {{ $user->education_level == 'master' ? 'selected' : '' }}>
                            @lang('dashboard.Master')</option>
                        <option value="phd" {{ $user->education_level == 'phd' ? 'selected' : '' }}>@lang('dashboard.PhD')
                        </option>
                        <option value="other" {{ $user->education_level == 'other' ? 'selected' : '' }}>@lang('dashboard.Other')
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
                    label="{{ __('dashboard.Annual Income') }}" placeholder="{{ __('dashboard.Enter annual income') }}"
                    value="{{ $user->annual_income }}" />

                <x-input.input-field name="total_savings" type="number" step="0.01"
                    label="{{ __('dashboard.Total Savings') }}" placeholder="{{ __('dashboard.Enter total savings') }}"
                    value="{{ $user->total_savings }}" />

                <div class="mb-3">
                    <label class="form-label">@lang('dashboard.Bank')</label>
                    <select name="bank_id" class="form-control">
                        <option value="">@lang('dashboard.Select Bank')</option>
                        @foreach (\App\Models\Bank::active()->get() as $bank)
                            <option value="{{ $bank->id }}" {{ $user->bank_id == $bank->id ? 'selected' : '' }}>
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

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                            {{ $user->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            @lang('dashboard.Is Active?')
                        </label>
                    </div>
                </div>

                <!-- Registration Answers -->
                @if ($user->registrationAnswers && $user->registrationAnswers->count() > 0)
                    <div class="row mb-3 mt-4">
                        <div class="col-12">
                            <h5 class="mb-3 text-primary">@lang('dashboard.Registration Answers')</h5>
                            <p class="text-muted small">@lang('dashboard.Questions are True/False type only')</p>
                        </div>
                    </div>

                    @foreach ($user->registrationAnswers as $answer)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="ri-question-line me-2"></i>
                                {{ $answer->question->question_text }}
                            </label>
                            <input type="hidden" name="answers[{{ $answer->id }}][question_id]"
                                value="{{ $answer->question_id }}">
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="answers[{{ $answer->id }}][answer]" id="ans{{ $answer->id }}_true"
                                        value="true" {{ $answer->answer == 'true' ? 'checked' : '' }}>
                                    <label class="form-check-label text-success" for="ans{{ $answer->id }}_true">
                                        <i class="ri-check-line me-1"></i>@lang('dashboard.True')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="answers[{{ $answer->id }}][answer]" id="ans{{ $answer->id }}_false"
                                        value="false" {{ $answer->answer == 'false' ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger" for="ans{{ $answer->id }}_false">
                                        <i class="ri-close-line me-1"></i>@lang('dashboard.False')
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </x-form.form-component>

        </x-cards.page-card>
    </div>
@endsection
@section('js_addons')

@endsection
