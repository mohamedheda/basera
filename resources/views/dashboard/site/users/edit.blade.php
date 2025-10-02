@extends('dashboard.core.app')
@section('title', __('dashboard.users'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.users') }}" :breadcrumbs="[['name' => __('dashboard.users'), 'route' => 'users.index'], ['name' => __('dashboard.Edit')]]" />

        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>

            <x-form.form-component :route="route('users.update', $user->id)" method="PUT">
                <input hidden name="company_id" value="{{ request('company') }}">

                <x-input.input-field name="name" label="{{ __('dashboard.Name') }}" placeholder="{{ __('dashboard.Name') }}"
                    value="{{ $user->name }}" required="true" />

                <x-input.input-field name="email" type="email" label="{{ __('dashboard.Email') }}"
                    placeholder="{{ __('dashboard.Email') }}" value="{{ $user->email }}" required="true" />

                <x-input.input-field name="password" type="password" label="{{ __('dashboard.password') }}"
                    placeholder="{{ __('dashboard.password') }}" />

                <x-input.input-field name="password_confirmation" type="password"
                    label="{{ __('dashboard.password_confirmation') }}"
                    placeholder="{{ __('dashboard.password_confirmation') }}" />
            </x-form.form-component>

        </x-cards.page-card>
    </div>
@endsection
@section('js_addons')

@endsection
