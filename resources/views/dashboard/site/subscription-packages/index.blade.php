@extends('dashboard.core.app')
@section('title', __('dashboard.Subscription Packages'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Subscription Packages') }}" :breadcrumbs="[['name' => __('dashboard.Subscription Packages'), 'route' => 'subscription-packages.index']]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Subscription Packages List')
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <a href="{{ route('subscription-packages.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> @lang('dashboard.Create')
                        </a>
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="packages_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.Package Name')</th>
                            <th>@lang('dashboard.Duration')</th>
                            <th>@lang('dashboard.Price')</th>
                            <th>@lang('dashboard.Status')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                            <tr id="row-{{ $package->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $package->name }}</td>
                                <td>
                                    {{ $package->duration_months }} @lang('dashboard.Months')
                                    <span class="badge bg-info">{{ $package->duration_name }}</span>
                                </td>
                                <td>{{ $package->formatted_price }}</td>
                                <td>
                                    @if ($package->is_active)
                                        <span class="badge bg-success">@lang('dashboard.Active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('dashboard.Inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="{{ route('subscription-packages.edit', $package->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-warning toggle-status"
                                            data-id="{{ $package->id }}">
                                            <i class="ti ti-toggle-left"></i>
                                        </button>

                                        <x-buttons.delete-button :route="route('subscription-packages.destroy', $package->id)" :itemId="$package->id" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('dashboard.core.includes.no-entries', ['columns' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $packages->links() }}
            </div>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.toggle-status', function() {
                var packageId = $(this).data('id');

                $.ajax({
                    url: "{{ url('subscription-packages') }}/" + packageId + "/toggle",
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
