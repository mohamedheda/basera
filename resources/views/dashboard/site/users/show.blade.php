@extends('dashboard.core.app')
@section('title', __('dashboard.users'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.users') }}" :breadcrumbs="[['name' => __('dashboard.users'), 'route' => 'users.index'], ['name' => __('dashboard.details')]]" />

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.details')
                </div>
            </x-slot>
            <div class=" d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed">
                <div>
                    <span class="avatar avatar-xxl avatar-rounded online me-3">
                        <img src="../assets/images/faces/9.jpg" alt="">
                    </span>
                </div>
                <div class="flex-fill main-profile-info">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="fw-semibold mb-1 text-fixed-dark p-2">{{ $user->name }}</h3>
                        <x-buttons.edit-button :route="route('users.edit', $user->id)" />

                    </div>
                </div>
            </div>
            <div class="p-4 border-bottom border-block-end-dashed">
                <p class="fs-15 mb-3 me-4 fw-semibold text-primary">
                    @lang('dashboard.Contact Information :')
                </p>
                <div class="text-muted">
                    @isset($user->company)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-building-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.company'):</strong> {{ $user->company->t('name') }}
                        </p>
                    @endisset

                    @isset($user->email)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-mail-line align-middle fs-14 "></i>
                            </span>
                            <strong>@lang('dashboard.Email'):</strong> {{ $user->email }}
                        </p>
                    @endisset

                    @isset($user->phone)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-phone-line align-middle fs-14 "></i>
                            </span>
                            <strong>@lang('dashboard.phone'):</strong> {{ $user->phone }}
                        </p>
                    @endisset

                    @isset($user->direct_manager_name)
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-user-star-line align-middle fs-14"></i>
                            </span>
                            <strong>@lang('dashboard.direct_manager_name'):</strong> {{ $user->direct_manager_name }}
                        </p>
                    @endisset

                    @isset($user->direct_manager_email)
                        <p class="mb-0">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted shadow-sm">
                                <i class="ri-mail-send-line align-middle fs-14 "></i>
                            </span>
                            <strong>@lang('dashboard.direct_manager_email'):</strong> {{ $user->direct_manager_email }}
                        </p>
                    @endisset
                </div>
            </div>

            <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-center">
                <p class="fs-15 mb-2 me-4 fw-semibold">Social Networks :</p>
                <div class="btn-list mb-0">
                    <button class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                        <i class="ri-facebook-line fw-semibold"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-secondary-light btn-wave waves-effect waves-light">
                        <i class="ri-twitter-line fw-semibold"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-warning-light btn-wave waves-effect waves-light">
                        <i class="ri-instagram-line fw-semibold"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-success-light btn-wave waves-effect waves-light">
                        <i class="ri-github-line fw-semibold"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-danger-light btn-wave waves-effect waves-light">
                        <i class="ri-youtube-line fw-semibold"></i>
                    </button>
                </div>
            </div>

        </x-cards.page-card>
        <!-- Page Card -->




    </div>



@endsection
@section('js_addons')

@endsection
