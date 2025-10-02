<form action="{{ $route }}" method="post" enctype="{{ $enctype }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    <div class="row py-3 px-2">
        {{ $slot }}

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                {{ $method === 'POST' ? __('dashboard.Create') : __('dashboard.Update') }}
            </button>
        </div>
    </div>
</form>
