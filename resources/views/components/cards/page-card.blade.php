@props(['header' => null, 'footer' => null])

<div class="row p-2">
    <div class="col-12">
        <div class="row">
            <div class="card custom-card">

                @if ($header)
                    <div class="card-header justify-content-between">
                        {{ $header }}
                    </div>
                @endif

                <div class="card-body p-0">
                   
                        {{ $slot }}
                 
                </div>

                @if ($footer)
                    <div class="card-footer">
                        {{ $footer }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
