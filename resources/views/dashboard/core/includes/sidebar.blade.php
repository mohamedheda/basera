<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('/') }}" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png" alt="logo') }}" class="toggle-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png" alt="logo') }}" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png" alt="logo') }}" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__Main -->
                <!-- End::slide__Main -->
                {{-- one slide dashboard --}}

                {{-- settings --}}
                <li class="slide">
                    <a href="{{ route('settings.edit', auth()->user()->id) }}"
                        class="side-menu__item {{ request()->routeIs('settings.edit') ? 'active' : '' }}">
                        <i class="ti ti-settings side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.Settings')</span>
                    </a>
                </li>

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ url('/') }}" class="side-menu__item {{ request()->routeIs('/') ? 'active' : '' }}">
                        <i class="ti ti-dashboard side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.Dashboard')</span>
                    </a>
                </li>

                {{-- end one slide dashboard --}}
                {{-- Registration Questions --}}
                <li class="slide">
                    <a href="{{ route('registration-questions.index') }}"
                        class="side-menu__item {{ request()->routeIs('registration-questions.*') ? 'active' : '' }}">
                        <i class="ti ti-help side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.Registration Questions')</span>
                    </a>
                </li>

                {{-- Banks --}}
                <li class="slide">
                    <a href="{{ route('banks.index') }}"
                        class="side-menu__item {{ request()->routeIs('banks.*') ? 'active' : '' }}">
                        <i class="ti ti-building-bank side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.Banks')</span>
                    </a>
                </li>
                {{-- end nested slide slide users --}}

                <li class="slide">
                    <a href="{{ route('users.index') }}"
                        class="side-menu__item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="ti ti-user side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.users')</span>
                    </a>
                </li>
                {{-- Subscription Packages --}}
                <li class="slide">
                    <a href="{{ route('subscription-packages.index') }}"
                        class="side-menu__item {{ request()->routeIs('subscription-packages.*') ? 'active' : '' }}">
                        <i class="ti ti-package side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.Subscription Packages')</span>
                    </a>
                </li>

                {{-- User Subscriptions --}}
                <li class="slide">
                    <a href="{{ route('subscriptions.index') }}"
                        class="side-menu__item {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                        <i class="ti ti-credit-card side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.User Subscriptions')</span>
                    </a>
                </li>

                {{-- Investment Opportunities --}}
                <li class="slide">
                    <a href="{{ route('investment-opportunities.index') }}"
                        class="side-menu__item {{ request()->routeIs('investment-opportunities.*') ? 'active' : '' }}">
                        <i class="ti ti-chart-line side-menu__icon"></i>
                        <span class="side-menu__label">@lang('dashboard.Investment Opportunities')</span>
                    </a>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
