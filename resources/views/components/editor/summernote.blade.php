@section('css_addons')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/summernote/summernote-bs5.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/lang/summernote-ar-AR.min.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/lang/summernote-en-US.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#{{ $id }}').summernote({
                height: 200,
                minHeight: 100,
                maxHeight: 500,
                focus: true,
                lang: "{{ app()->getLocale() === 'ar' ? 'ar-AR' : 'en-US' }}",
                placeholder: "{{ app()->getLocale() === 'ar' ? 'اكتب هنا...' : 'Write here...' }}",
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript',
                        'subscript'
                    ]],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['misc', ['undo', 'redo']]
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['insert', ['link', 'picture']]
                    ]
                }
            });
        });
    </script>
@endpush

<div class="col-md-12 mb-3">
    <label class="form-label" for="{{ $id }}">@lang($label)</label>
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control">{!! old($name, $value) !!}</textarea>
</div>
