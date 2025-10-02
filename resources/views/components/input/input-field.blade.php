<div class="{{ $wrapperClass ?? 'col-md-6 mb-3' }}">
    @if ($label)
        <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    @endif

    @if ($type === 'checkbox')
        <div class="form-check">
            <input type="checkbox" name="{{ $name }}" class="form-check-input {{ $class }}"
                id="{{ $id }}" {{ old($name, $value) ? 'checked' : '' }} {{ $required ? 'required' : '' }}>
            <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
        </div>
    @else
        <input type="{{ $type }}" name="{{ $name }}" class="form-control {{ $class }}"
            id="{{ $id }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}"
            {{ $required ? 'required' : '' }}>
    @endif

    @error($name)
        <div class="text-danger p-2">{{ $message }}</div>
    @enderror
</div>
