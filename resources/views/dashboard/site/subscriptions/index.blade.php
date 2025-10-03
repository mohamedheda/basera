@extends('dashboard.core.app')
@section('title', __('dashboard.User Subscriptions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.User Subscriptions') }}" :breadcrumbs="[['name' => __('dashboard.User Subscriptions'), 'route' => 'subscriptions.index']]" />

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Total Subscriptions')</h5>
                        <h2 class="mb-0">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Active Subscriptions')</h5>
                        <h2 class="mb-0">{{ $stats['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Cancelled Subscriptions')</h5>
                        <h2 class="mb-0">{{ $stats['cancelled'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Total Revenue')</h5>
                        <h2 class="mb-0">{{ number_format($stats['total_revenue'], 0) }} ر.س</h2>
                    </div>
                </div>
            </div>
        </div>

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.User Subscriptions List')
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="subscriptions_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.User')</th>
                            <th>@lang('dashboard.Package')</th>
                            <th>@lang('dashboard.Start Date')</th>
                            <th>@lang('dashboard.End Date')</th>
                            <th>@lang('dashboard.Amount Paid')</th>
                            <th>@lang('dashboard.Payment Method')</th>
                            <th>@lang('dashboard.Status')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr id="row-{{ $subscription->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $subscription->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $subscription->user->email ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $subscription->subscriptionPackage->name ?? 'N/A' }}</td>
                                <td>{{ $subscription->start_date?->format('Y-m-d') }}</td>
                                <td>{{ $subscription->end_date?->format('Y-m-d') }}</td>
                                <td>{{ number_format($subscription->amount_paid, 0) }} ر.س</td>
                                <td>{{ $subscription->payment_method }}</td>
                                <td>
                                    @if ($subscription->status == 'active' && $subscription->end_date >= now())
                                        <span class="badge bg-success">@lang('dashboard.Active')</span>
                                    @elseif($subscription->status == 'cancelled')
                                        <span class="badge bg-warning">@lang('dashboard.Cancelled')</span>
                                    @else
                                        <span class="badge bg-danger">@lang('dashboard.Expired')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="{{ route('subscriptions.show', $subscription->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        @if ($subscription->status == 'active' && $subscription->end_date >= now())
                                            <button type="button" class="btn btn-sm btn-warning update-status"
                                                data-id="{{ $subscription->id }}" data-status="cancelled">
                                                <i class="ti ti-ban"></i>
                                            </button>
                                        @endif

                                        <x-buttons.delete-button :route="route('subscriptions.destroy', $subscription->id)" :itemId="$subscription->id" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('dashboard.core.includes.no-entries', ['columns' => 9])
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $subscriptions->links() }}
            </div>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.update-status', function() {
                var subscriptionId = $(this).data('id');
                var status = $(this).data('status');

                if (confirm('@lang('dashboard.Are you sure you want to update the subscription status?')')) {
                    $.ajax({
                        url: "{{ url('subscriptions') }}/" + subscriptionId + "/status/" + status,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
