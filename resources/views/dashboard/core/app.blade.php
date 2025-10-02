@php use Illuminate\Support\Facades\Session; @endphp
<!DOCTYPE html>
{{-- <html lang="{{ app()->getLocale() }}" @if (app()->getLocale() == 'ar') id="rtl" @endif> --}}
<html lang="{{ app()->getLocale() }}" class="{{ app()->getLocale() === 'ar' ? 'direction-rtl' : 'direction-ltr' }}"
    data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark"
    data-toggled="close">

@include('dashboard.core.tags.head')

<body>
    <div class="page">
        @include('dashboard.core.includes.header')

        @include('dashboard.core.includes.sidebar')

        <div class="main-content app-content">
            @yield('content')
        </div>

        @include('dashboard.core.includes.footer')
    </div>
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    @include('dashboard.core.tags.scripts')

    @if (Session::has('success'))
        @include('dashboard.core.alerts.sweet-alert.success')
    @endif

</body>

</html>
