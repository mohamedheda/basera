@extends('dashboard.core.app')
@section('title', __('dashboard.Registration Questions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Registration Questions') }}" :breadcrumbs="[['name' => __('dashboard.Registration Questions'), 'route' => 'registration-questions.index']]" />
        <!-- Page Header Close -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    {{ __('dashboard.Registration Questions') }}
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <a href="{{ route('registration-questions.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> {{ __('dashboard.add') }}
                        </a>
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="questions_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.Question') (@lang('dashboard.en'))</th>
                            <th>@lang('dashboard.Question') (@lang('dashboard.ar'))</th>
                            <th>@lang('dashboard.Status')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr id="row-{{ $question->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->question_text_en }}</td>
                                <td>{{ $question->question_text_ar }}</td>
                                <td>
                                    @if ($question->is_active)
                                        <span class="badge bg-success">@lang('dashboard.Active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('dashboard.Inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="{{ route('registration-questions.edit', $question->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-warning toggle-status"
                                            data-id="{{ $question->id }}" data-status="{{ $question->is_active }}">
                                            <i class="ti ti-toggle-left"></i>
                                        </button>

                                        <x-buttons.delete-button :route="route('registration-questions.destroy', $question->id)" :itemId="$question->id" />
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
                {{ $questions->links() }}
            </div>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.toggle-status', function() {
                var button = $(this);
                var questionId = button.data('id');
                var currentStatus = button.data('status');
                var row = $('#row-' + questionId);

                // Disable button during request
                button.prop('disabled', true);

                $.ajax({
                    url: "{{ url('registration-questions') }}/" + questionId + "/toggle",
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
