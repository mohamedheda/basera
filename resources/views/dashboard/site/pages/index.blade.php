@extends('dashboard.core.app')
@section('title', __('dashboard.Pages'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Pages') }}" :breadcrumbs="[['name' => __('dashboard.Pages'), 'route' => 'pages.index']]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Pages List')
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        {{-- <a href="{{ route('pages.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> @lang('dashboard.Create')
                        </a> --}}
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="pages_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.Slug')</th>
                            <th>@lang('dashboard.Title (English)')</th>
                            <th>@lang('dashboard.Title (Arabic)')</th>
                            <th>@lang('dashboard.Status')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr id="row-{{ $page->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>{{ $page->title_en }}</td>
                                <td>{{ $page->title_ar }}</td>
                                <td>
                                    @if ($page->is_active)
                                        <span class="badge bg-success">@lang('dashboard.Active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('dashboard.Inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-warning toggle-status"
                                            data-id="{{ $page->id }}">
                                            <i class="ti ti-toggle-left"></i>
                                        </button>

                                        {{-- <x-buttons.delete-button :route="route('pages.destroy', $page->id)" :itemId="$page->id" /> --}}
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
                {{ $pages->links() }}
            </div>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.toggle-status', function() {
                var pageId = $(this).data('id');

                $.ajax({
                    url: "{{ url('pages') }}/" + pageId + "/toggle",
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
