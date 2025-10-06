@extends('dashboard.core.app')
@section('title', __('dashboard.Home'))
@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Home') }}" />
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">
            <!-- إحصائيات المستخدمين -->
            <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <span class="rounded p-3 bg-primary-transparent">
                                    <i class="ri-user-line fs-24 text-primary"></i>
                                </span>
                            </div>
                            <div class="col-8 ps-0">
                                <div class="mb-2">@lang('dashboard.Total Users')</div>
                                <div class="text-muted mb-1 fs-12">
                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom">
                                        {{ number_format($totalUsers) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="fs-12 mb-0">
                                        @if ($usersGrowth >= 0)
                                            <span class="badge bg-success-transparent text-success mx-1">
                                                +{{ $usersGrowth }}%
                                            </span>
                                        @else
                                            <span class="badge bg-danger-transparent text-danger mx-1">
                                                {{ $usersGrowth }}%
                                            </span>
                                        @endif
                                        @lang('dashboard.this month')
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المستخدمون النشطون -->
            <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <span class="rounded p-3 bg-success-transparent">
                                    <i class="ri-user-check-line fs-24 text-success"></i>
                                </span>
                            </div>
                            <div class="col-8 ps-0">
                                <div class="mb-2">@lang('dashboard.Active Users')</div>
                                <div class="text-muted mb-1 fs-12">
                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom">
                                        {{ number_format($activeUsers) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="fs-12 mb-0 text-muted">
                                        {{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}%
                                        @lang('dashboard.of total')
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إجمالي الاشتراكات -->
            <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <span class="rounded p-3 bg-warning-transparent">
                                    <i class="ri-shopping-bag-line fs-24 text-warning"></i>
                                </span>
                            </div>
                            <div class="col-8 ps-0">
                                <div class="mb-2">@lang('dashboard.Total Subscriptions')</div>
                                <div class="text-muted mb-1 fs-12">
                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom">
                                        {{ number_format($totalSubscriptions) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="fs-12 mb-0 text-success">
                                        {{ number_format($activeSubscriptions) }} @lang('dashboard.Active')
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إجمالي الإيرادات -->
            <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <span class="rounded p-3 bg-info-transparent">
                                    <i class="ri-money-dollar-circle-line fs-24 text-info"></i>
                                </span>
                            </div>
                            <div class="col-8 ps-0">
                                <div class="mb-2">@lang('dashboard.Total Revenue')</div>
                                <div class="text-muted mb-1 fs-12">
                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom">
                                        {{ number_format($totalRevenue, 2) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="fs-12 mb-0 text-muted">
                                        @lang('dashboard.SAR')
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-1 -->

        <!-- Start::row-2 -->
        <div class="row">
            <!-- الفرص الاستثمارية -->
            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">@lang('dashboard.Investment Opportunities')</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <div class="fs-14 text-muted">@lang('dashboard.Total Opportunities')</div>
                                <div class="fs-24 fw-semibold text-primary">{{ number_format($totalOpportunities) }}</div>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-primary-transparent">
                                    <i class="ri-line-chart-line fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fs-13 text-muted">@lang('dashboard.Halal Opportunities')</div>
                                <div class="fs-20 fw-semibold text-success">{{ number_format($halalOpportunities) }}</div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success-transparent text-success">
                                    {{ $totalOpportunities > 0 ? round(($halalOpportunities / $totalOpportunities) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المديرون والأسئلة -->
            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">@lang('dashboard.System')</div>
                    </div>
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fs-13 text-muted">@lang('dashboard.Registration Questions')</div>
                                <div class="fs-20 fw-semibold text-warning">{{ number_format($totalQuestions) }}</div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('registration-questions.index') }}" class="btn btn-sm btn-primary-light">
                                    @lang('dashboard.Manage')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-2 -->

        <!-- Start::row-3 - Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">@lang('dashboard.Quick Actions')</div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('users.create') }}" class="btn btn-primary-light w-100">
                                    <i class="ri-user-add-line me-2"></i>@lang('dashboard.Add User')
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary-light w-100">
                                    <i class="ri-user-line me-2"></i>@lang('dashboard.View Users')
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('subscription-packages.index') }}" class="btn btn-warning-light w-100">
                                    <i class="ri-shopping-bag-line me-2"></i>@lang('dashboard.Subscription Packages')
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('investment-opportunities.index') }}" class="btn btn-info-light w-100">
                                    <i class="ri-line-chart-line me-2"></i>@lang('dashboard.Investment Opportunities')
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('subscriptions.index') }}" class="btn btn-success-light w-100">
                                    <i class="ri-file-list-line me-2"></i>@lang('dashboard.User Subscriptions')
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('registration-questions.index') }}"
                                    class="btn btn-primary-light w-100">
                                    <i class="ri-question-line me-2"></i>@lang('dashboard.Registration Questions')
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('banks.index') }}" class="btn btn-secondary-light w-100">
                                    <i class="ri-bank-line me-2"></i>@lang('dashboard.Banks')
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-3 -->

    </div>
@endsection
