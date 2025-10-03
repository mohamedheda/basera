@extends('dashboard.core.app')
@section('title', __('Registration Questions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="Registration Questions" :breadcrumbs="[['name' => 'Registration Questions', 'route' => 'registration-questions.index']]" />
        <!-- Page Header Close -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    Registration Questions List
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <a href="{{ route('registration-questions.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Question
                        </a>
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="questions_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Question (English)</th>
                            <th>Question (Arabic)</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr id="row-{{ $question->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->question_text_en }}</td>
                                <td>{{ $question->question_text_ar }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $question->question_type }}</span>
                                </td>
                                <td>
                                    @if ($question->is_required)
                                        <span class="badge bg-danger">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($question->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $question->order }}</td>
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
                            @include('dashboard.core.includes.no-entries', ['columns' => 8])
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
                var questionId = $(this).data('id');
                var currentStatus = $(this).data('status');

                $.ajax({
                    url: "{{ url('registration-questions') }}/" + questionId + "/toggle",
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
