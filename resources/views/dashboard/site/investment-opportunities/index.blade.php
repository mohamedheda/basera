@extends('dashboard.core.app')
@section('title', __('dashboard.Investment Opportunities'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Investment Opportunities') }}" :breadcrumbs="[['name' => __('dashboard.Investment Opportunities'), 'route' => 'investment-opportunities.index']]" />

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Total Opportunities')</h5>
                        <h2 class="mb-0">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Active')</h5>
                        <h2 class="mb-0">{{ $stats['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Halal Opportunities')</h5>
                        <h2 class="mb-0">{{ $stats['halal'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">@lang('dashboard.Average Return')</h5>
                        <h2 class="mb-0">{{ $stats['average_return'] }}%</h2>
                    </div>
                </div>
            </div>
        </div>

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Investment Opportunities List')
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <a href="{{ route('investment-opportunities.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> @lang('dashboard.Create')
                        </a>
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="opportunities_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.Company Name')</th>
                            <th>@lang('dashboard.Market')</th>
                            <th>@lang('dashboard.Sector')</th>
                            <th>@lang('dashboard.Current Price')</th>
                            <th>@lang('dashboard.Expected Return')</th>
                            <th>@lang('dashboard.Risk Level')</th>
                            <th>@lang('dashboard.Halal')</th>
                            <th>@lang('dashboard.Status')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opportunities as $opportunity)
                            <tr id="row-{{ $opportunity->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $opportunity->company_name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $opportunity->market_name }}</span>
                                </td>
                                <td>{{ $opportunity->sector_name }}</td>
                                <td>{{ number_format($opportunity->current_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $opportunity->expected_return_percentage }}%</span>
                                </td>
                                <td>
                                    @if ($opportunity->risk_level == 'low')
                                        <span class="badge bg-success">@lang('dashboard.Low')</span>
                                    @elseif($opportunity->risk_level == 'medium')
                                        <span class="badge bg-warning">@lang('dashboard.Medium')</span>
                                    @else
                                        <span class="badge bg-danger">@lang('dashboard.High')</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($opportunity->is_halal)
                                        <span class="badge bg-success">@lang('dashboard.Yes')</span>
                                    @else
                                        <span class="badge bg-secondary">@lang('dashboard.No')</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($opportunity->is_active)
                                        <span class="badge bg-success">@lang('dashboard.Active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('dashboard.Inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="{{ route('investment-opportunities.edit', $opportunity->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-warning toggle-status"
                                            data-id="{{ $opportunity->id }}">
                                            <i class="ti ti-toggle-left"></i>
                                        </button>

                                        <x-buttons.delete-button :route="route('investment-opportunities.destroy', $opportunity->id)" :itemId="$opportunity->id" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('dashboard.core.includes.no-entries', ['columns' => 10])
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $opportunities->links() }}
            </div>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.toggle-status', function() {
                var opportunityId = $(this).data('id');

                $.ajax({
                    url: "{{ url('investment-opportunities') }}/" + opportunityId + "/toggle",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status == 200 || response.data === true) {
                            // Reload page to show updated status
                            location.reload();
                        } else {
                            alert(response.message || 'فشل التحديث');
                            button.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON?.message || 'حدث خطأ';
                        alert(errorMessage);
                        button.prop('disabled', false);
                    }
                });
            });
        </script>
    @endpush
@endsection
