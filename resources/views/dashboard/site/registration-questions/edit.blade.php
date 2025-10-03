@extends('dashboard.core.app')
@section('title', __('Registration Questions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- BreadCrumb -->
        <x-breadcrumb.breadcrumb title="Registration Questions" :breadcrumbs="[
            ['name' => 'Registration Questions', 'route' => 'registration-questions.index'],
            ['name' => __('dashboard.Edit')],
        ]" />
        <!-- BreadCrumb -->

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Edit') Question
                </div>
            </x-slot>
            <x-form.form-component :route="route('registration-questions.update', $question->id)" method="PUT">
                <div class="row">
                    <div class="col-md-6">
                        <x-input.input-field name="question_text_en" label="Question Text (English)"
                            placeholder="Enter question in English" required="true"
                            value="{{ $question->question_text_en }}" />
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="question_text_ar" label="Question Text (Arabic)"
                            placeholder="أدخل السؤال بالعربية" required="true" value="{{ $question->question_text_ar }}" />
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Question Type</label>
                            <select name="question_type" id="question_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Text
                                </option>
                                <option value="number" {{ $question->question_type == 'number' ? 'selected' : '' }}>Number
                                </option>
                                <option value="date" {{ $question->question_type == 'date' ? 'selected' : '' }}>Date
                                </option>
                                <option value="select" {{ $question->question_type == 'select' ? 'selected' : '' }}>Select
                                </option>
                                <option value="radio" {{ $question->question_type == 'radio' ? 'selected' : '' }}>Radio
                                </option>
                                <option value="checkbox" {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>
                                    Checkbox</option>
                                <option value="textarea" {{ $question->question_type == 'textarea' ? 'selected' : '' }}>
                                    Textarea</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="order" type="number" label="Order" placeholder="Display order"
                            required="true" value="{{ $question->order }}" />
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="validation_rules" label="Validation Rules (Optional)"
                            placeholder="e.g., required|string|max:100" required="false"
                            value="{{ $question->validation_rules }}" />
                    </div>

                    <div class="col-md-6" id="options_en_field"
                        style="display: {{ in_array($question->question_type, ['select', 'radio', 'checkbox']) ? 'block' : 'none' }};">
                        <div class="mb-3">
                            <label for="options_en" class="form-label">Options (English)</label>
                            <textarea name="options_en" id="options_en" class="form-control" rows="3"
                                placeholder="Enter options separated by commas: Option1,Option2,Option3">{{ isset($question->options['en']) ? implode(',', $question->options['en']) : '' }}</textarea>
                            <small class="text-muted">Separate options with commas</small>
                        </div>
                    </div>

                    <div class="col-md-6" id="options_ar_field"
                        style="display: {{ in_array($question->question_type, ['select', 'radio', 'checkbox']) ? 'block' : 'none' }};">
                        <div class="mb-3">
                            <label for="options_ar" class="form-label">Options (Arabic)</label>
                            <textarea name="options_ar" id="options_ar" class="form-control" rows="3"
                                placeholder="أدخل الخيارات مفصولة بفواصل: خيار1,خيار2,خيار3">{{ isset($question->options['ar']) ? implode(',', $question->options['ar']) : '' }}</textarea>
                            <small class="text-muted">افصل الخيارات بفواصل</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_required" id="is_required"
                                value="1" {{ $question->is_required ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">
                                Is Required?
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                {{ $question->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Is Active?
                            </label>
                        </div>
                    </div>
                </div>
            </x-form.form-component>
        </x-cards.page-card>
        <!-- Page Card -->
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#question_type').change(function() {
                    var type = $(this).val();
                    if (type == 'select' || type == 'radio' || type == 'checkbox') {
                        $('#options_en_field, #options_ar_field').show();
                    } else {
                        $('#options_en_field, #options_ar_field').hide();
                    }
                });
            });
        </script>
    @endpush
@endsection
