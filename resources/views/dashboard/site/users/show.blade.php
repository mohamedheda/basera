@extends('dashboard.core.app')
@section('title', __('dashboard.users'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.users') }}" :breadcrumbs="[['name' => __('dashboard.users'), 'route' => 'users.index'], ['name' => __('dashboard.details')]]" />

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.details')
                </div>
            </x-slot>
            <div class=" d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed">
                <div>
                    <span class="avatar avatar-xxl avatar-rounded online me-3">
                        <img src="../assets/images/faces/9.jpg" alt="">
                    </span>
                </div>
                <div class="flex-fill main-profile-info">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="fw-semibold mb-1 text-fixed-dark p-2">{{ $user->name }}</h3>
                        <x-buttons.edit-button :route="route('users.edit', $user->id)" />

                    </div>
                </div>
            </div>
            <!-- Contact Information -->
            <div class="p-4 border-bottom border-block-end-dashed">
                <p class="fs-15 mb-3 me-4 fw-semibold text-primary">
                    @lang('dashboard.Contact Information :')
                </p>
                <div class="text-muted">
                    @if ($user->email)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-mail-line align-middle fs-14 "></i>
                            </span>
                            <strong>@lang('dashboard.Email'):</strong> {{ $user->email }}
                        </p>
                    @endif

                    @if ($user->phone)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-phone-line align-middle fs-14 "></i>
                            </span>
                            <strong>@lang('dashboard.Phone'):</strong> {{ $user->phone }}
                        </p>
                    @endif

                    @if ($user->national_id)
                        <p class="mb-0">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-id-card-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.National ID'):</strong> {{ $user->national_id }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Personal Information -->
            <div class="p-4 border-bottom border-block-end-dashed">
                <p class="fs-15 mb-3 me-4 fw-semibold text-primary">
                    @lang('dashboard.Personal Information')
                </p>
                <div class="text-muted">
                    @if ($user->date_of_birth)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-calendar-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Date of Birth'):</strong> {{ $user->date_of_birth->format('Y-m-d') }}
                        </p>
                    @endif

                    @if ($user->marital_status)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-user-heart-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Marital Status'):</strong> @lang('dashboard.' . ucfirst($user->marital_status))
                        </p>
                    @endif

                    @if ($user->family_members_count !== null)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-group-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Family Members Count'):</strong> {{ $user->family_members_count }}
                        </p>
                    @endif

                    @if ($user->education_level)
                        <p class="mb-0">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-graduation-cap-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Education Level'):</strong> @lang('dashboard.' . str_replace('_', ' ', ucfirst($user->education_level)))
                        </p>
                    @endif
                </div>
            </div>

            <!-- Financial Information -->
            <div class="p-4 border-bottom border-block-end-dashed">
                <p class="fs-15 mb-3 me-4 fw-semibold text-primary">
                    @lang('dashboard.Financial Information')
                </p>
                <div class="text-muted">
                    @if ($user->annual_income)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-money-dollar-circle-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Annual Income'):</strong> {{ number_format($user->annual_income, 2) }}
                            @lang('dashboard.SAR')
                        </p>
                    @endif

                    @if ($user->total_savings)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-safe-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Total Savings'):</strong> {{ number_format($user->total_savings, 2) }}
                            @lang('dashboard.SAR')
                        </p>
                    @endif

                    @if ($user->bank)
                        <p class="mb-0">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-bank-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.Bank'):</strong> {{ $user->bank->name }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Account Status -->
            <div class="p-4 border-bottom border-block-end-dashed">
                <p class="fs-15 mb-3 me-4 fw-semibold text-primary">
                    @lang('dashboard.Account Status')
                </p>
                <div class="text-muted">
                    <p class="mb-2">
                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                            <i class="ri-shield-check-line align-middle fs-14"></i>
                        </span>
                        <strong>@lang('dashboard.Status'):</strong>
                        @if ($user->is_active)
                            <span class="badge bg-success ms-2">@lang('dashboard.Active')</span>
                        @else
                            <span class="badge bg-danger ms-2">@lang('dashboard.Inactive')</span>
                        @endif
                    </p>

                    <p class="mb-2">
                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                            <i class="ri-checkbox-circle-line align-middle fs-14"></i>
                        </span>
                        <strong>@lang('dashboard.OTP Verified'):</strong>
                        @if ($user->otp_verified)
                            <span class="badge bg-success ms-2">@lang('dashboard.Verified')</span>
                        @else
                            <span class="badge bg-warning ms-2">@lang('dashboard.Not Verified')</span>
                        @endif
                    </p>

                </div>
            </div>

            <!-- Registration Answers -->
            <div class="p-4">
                <p class="fs-15 mb-3 me-4 fw-semibold text-primary">
                    @lang('dashboard.Registration Answers')
                </p>
                <div class="text-muted">
                    @if ($user->registrationAnswers && $user->registrationAnswers->count() > 0)
                        @foreach ($user->registrationAnswers as $answer)
                            <div class="mb-3 pb-3 border-bottom">
                                <p class="mb-2">
                                    <i class="ri-question-line me-2"></i>
                                    <strong>{{ $answer->question->question_text }}</strong>
                                </p>
                                <p class="mb-0 ms-4">
                                    @if ($answer->answer == 'true')
                                        <span class="badge bg-success">
                                            <i class="ri-check-line me-1"></i>@lang('dashboard.True')
                                        </span>
                                    @elseif ($answer->answer == 'false')
                                        <span class="badge bg-danger">
                                            <i class="ri-close-line me-1"></i>@lang('dashboard.False')
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">{{ $answer->answer }}</span>
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    @else
                        <p class="mb-0 text-center">
                            <i class="ri-question-mark align-middle fs-14 me-2"></i>
                            <em>@lang('dashboard.User has not answered any registration questions yet')</em>
                        </p>
                    @endif
                </div>
            </div>

        </x-cards.page-card>
        <!-- Page Card -->

    </div>

@endsection
@section('js_addons')

@endsection
