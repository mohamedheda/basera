<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@lang('dashboard.Elryad') | @lang('dashboard.Dashboard') | @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Bootstrap Css -->

    @if (app()->getLocale() === 'ar')
        <link id="style" rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css') }}">
    @else
        <link id="style" rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
    @endif
    {{-- <link id="style" rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}"> --}}

    <!-- Style Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

    <!-- Icons Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">

    <!-- Node Waves Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/node-waves/waves.min.css') }}">

    <!-- Simplebar Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    @if (app()->getLocale() == 'ar')
        <!-- Override RTL theme style -->
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
    @endif

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap RTL CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

    <style>
        .direction-ltr {
            direction: ltr !important;
        }

        .direction-rtl {
            direction: rtl !important;
        }

        .breadcrumb-contain {
            direction: ltr !important;
        }
    </style>
    <!-- CSS addons -->
    @yield('css_addons')
</head>
