@extends('dashboard.core.app')
@section('title', __('dashboard.Subscription Details'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Subscription Details') }}" :breadcrumbs="[
            ['name' => __('dashboard.User Subscriptions'), 'route' => 'subscriptions.index'],
            ['name' => __('dashboard.Details')],
        ]" />

        <div class="row">
            <!-- Subscription Details -->
            <div class="col-md-8">
                <x-cards.page-card>
                    <x-slot name="header">
                        <div class="card-title">
                            @lang('dashboard.Subscription Information')
                        </div>
                    </x-slot>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Subscription ID'):</strong>
                            <p class="text-muted">#{{ $subscription->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Status'):</strong>
                            <p>
                                @if ($subscription->status == 'active' && $subscription->end_date >= now())
                                    <span class="badge bg-success">@lang('dashboard.Active')</span>
                                @elseif($subscription->status == 'cancelled')
                                    <span class="badge bg-warning">@lang('dashboard.Cancelled')</span>
                                @else
                                    <span class="badge bg-danger">@lang('dashboard.Expired')</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Start Date'):</strong>
                            <p class="text-muted">{{ $subscription->start_date?->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('dashboard.End Date'):</strong>
                            <p class="text-muted">{{ $subscription->end_date?->format('Y-m-d') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Amount Paid'):</strong>
                            <p class="text-muted">{{ number_format($subscription->amount_paid, 0) }} ر.س</p>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Payment Method'):</strong>
                            <p class="text-muted">{{ $subscription->payment_method }}</p>
                        </div>
                    </div>

                    @if ($subscription->transaction_id)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong>@lang('dashboard.Transaction ID'):</strong>
                                <p class="text-muted">{{ $subscription->transaction_id }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Created At'):</strong>
                            <p class="text-muted">{{ $subscription->created_at?->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('dashboard.Updated At'):</strong>
                            <p class="text-muted">{{ $subscription->updated_at?->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </x-cards.page-card>
            </div>

            <!-- User & Package Info -->
            <div class="col-md-4">
                <!-- User Info -->
                <x-cards.page-card>
                    <x-slot name="header">
                        <div class="card-title">
                            @lang('dashboard.User Information')
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <strong>@lang('dashboard.Name'):</strong>
                        <p class="text-muted">{{ $subscription->user->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>@lang('dashboard.Email'):</strong>
                        <p class="text-muted">{{ $subscription->user->email ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>@lang('dashboard.Phone'):</strong>
                        <p class="text-muted">{{ $subscription->user->phone ?? 'N/A' }}</p>
                    </div>
                </x-cards.page-card>

                <!-- Package Info -->
                <x-cards.page-card>
                    <x-slot name="header">
                        <div class="card-title">
                            @lang('dashboard.Package Information')
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <strong>@lang('dashboard.Package Name'):</strong>
                        <p class="text-muted">{{ $subscription->subscriptionPackage->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>@lang('dashboard.Duration'):</strong>
                        <p class="text-muted">{{ $subscription->subscriptionPackage->duration_months ?? 'N/A' }}
                            @lang('dashboard.Months')</p>
                    </div>

                    <div class="mb-3">
                        <strong>@lang('dashboard.Price'):</strong>
                        <p class="text-muted">{{ $subscription->subscriptionPackage->formatted_price ?? 'N/A' }}</p>
                    </div>

                    @if ($subscription->subscriptionPackage->is_popular)
                        <span class="badge bg-success">@lang('dashboard.Popular Package')</span>
                    @endif
                </x-cards.page-card>
            </div>
        </div>
    </div>
@endsection
