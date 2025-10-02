<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ app()->getLocale() === 'ar' ? 'direction-rtl' : 'direction-ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('dashboard.Login')</title>
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
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


        body {
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
        }

        .btn-primary {
            width: 100%;
        }

        .form-control {
            text-align: right;
        }

        .input-group-text {
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #0d6efd;
        }

        a:hover {

            color: #0a58ca;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <a href="" class="app-brand-link">
                                <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="Logo"
                                    style="width: 80px; height: auto;">
                                <span class="app-brand-text demo menu-text fw-bold">@lang('dashboard.Elryad')</span>
                            </a>
                        </div>

                        <form action="{{ route('auth.login') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">@lang('dashboard.Email')</label>
                                <input name="email" type="email" class="form-control" id="email"
                                    placeholder="@lang('dashboard.Email')" autofocus required>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">@lang('dashboard.Password')</label>

                                </div>
                                <div class="input-group input-group-merge">
                                    <input name="password" type="password" id="password" class="form-control"
                                        placeholder="@lang('dashboard.Password')" aria-describedby="password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember_me" type="checkbox" id="remember"
                                        checked>
                                    <label class="form-check-label" for="remember_me">@lang('dashboard.Remember Me')</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">@lang('dashboard.Login')</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr JS -->
    {{-- <script src="{{ asset('assets/js/Toasts.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alerts.js') }}"></script>
    {{-- @if (Session::has('error'))
        @include('dashboard.core.alerts.toasts.error')
    @endif --}}

    @include('dashboard.core.alerts.sweet-alert.error')


</body>

</html>
