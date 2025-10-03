@extends('dashboard.core.app')
@section('title', __('dashboard.Banks'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Banks') }}" :breadcrumbs="[['name' => __('dashboard.Banks'), 'route' => 'banks.index']]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Banks List')
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <a href="{{ route('banks.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> @lang('dashboard.Create')
                        </a>
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="banks_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.Name (English)')</th>
                            <th>@lang('dashboard.Name (Arabic)')</th>
                            <th>@lang('dashboard.Status')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banks as $bank)
                            <tr id="row-{{ $bank->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bank->name_en }}</td>
                                <td>{{ $bank->name_ar }}</td>
                                <td>
                                    @if ($bank->is_active)
                                        <span class="badge bg-success">@lang('dashboard.Active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('dashboard.Inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-warning toggle-status"
                                            data-id="{{ $bank->id }}">
                                            <i class="ti ti-toggle-left"></i>
                                        </button>

                                        <x-buttons.delete-button :route="route('banks.destroy', $bank->id)" :itemId="$bank->id" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('dashboard.core.includes.no-entries', ['columns' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $banks->links() }}
            </div>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.toggle-status', function() {
                var bankId = $(this).data('id');

                $.ajax({
                    url: "{{ url('banks') }}/" + bankId + "/toggle",
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
            });
        </script>
    @endpush
@endsection
