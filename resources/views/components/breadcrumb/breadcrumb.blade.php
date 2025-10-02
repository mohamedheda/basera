@props(['title', 'breadcrumbs' => []])

<!-- Breadcrumb Component -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">{{ $title }}</h1>
    <div class="ms-md-1 ms-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                @if (!($title && empty($breadcrumbs)))
                    <li class="breadcrumb-item">
                        <a href="{{ route('/') }}" class="text-primary fw-semibold">
                            <i class="mdi mdi-home-outline"></i> @lang('dashboard.Home')
                        </a>
                    </li>
                @endif

                @foreach ($breadcrumbs as $breadcrumb)
                    @if ($loop->last)
                        <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">
                            {{ $breadcrumb['name'] }}
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            @if (isset($breadcrumb['route']))
                                <a href="{{ route($breadcrumb['route'], $breadcrumb['params'] ?? []) }}">
                                    {{ $breadcrumb['name'] }}
                                </a>
                            @else
                                {{ $breadcrumb['name'] }}
                            @endif
                        </li>
                    @endif
                @endforeach

            </ol>
        </nav>
    </div>
</div>
<!-- Breadcrumb Component End -->
