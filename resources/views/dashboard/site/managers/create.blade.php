@extends('dashboard.core.app')
@section('title', __('dashboard.Manager'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- BreadCrumb -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Manager') }}" :breadcrumbs="[['name' => __('dashboard.Manager')], ['name' => __('dashboard.Create')]]" />
        <!-- BreadCrumb -->

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>
            <x-form.form-component :route="route('managers.store')" method="POST">

                <input type="hidden" name="role_id" value=" {{ $role->id }}" />
                <x-input.input-field name="name" label="{{ __('dashboard.Name') }}"
                    placeholder="{{ __('dashboard.Name') }}" class="custom-class" id="name" required="true" />

                <x-input.input-field name="email" type="email" label="{{ __('dashboard.Email') }}"
                    placeholder="{{ __('dashboard.Email') }}" required="true" />

                <x-input.input-field name="phone" type="phone" label="{{ __('dashboard.Phone') }}"
                    placeholder="{{ __('dashboard.Phone') }}" required="true" />

                <div class="row mt-3">
                    <x-input.input-field name="password" type="password" label="{{ __('dashboard.password') }}"
                        placeholder="{{ __('dashboard.password') }}" required="true" />

                    <x-input.input-field name="password_confirmation" type="password"
                        label="{{ __('dashboard.password_confirmation') }}"
                        placeholder="{{ __('dashboard.password_confirmation') }}" required="true" />
                </div>
                <div class="row mt-3">
                    <x-input.input-field class="" type="checkbox" name="is_active" id="is_active"
                        label="{{ __('dashboard.Activate') }}"  />
                </div>

                <x-input.input-field name="image" type="file" label="{{ __('dashboard.Image') }}" required="true" />

            </x-form.form-component>
        </x-cards.page-card>
        <!-- Page Card -->

    </div>
@endsection
@section('js_addons')

@endsection
