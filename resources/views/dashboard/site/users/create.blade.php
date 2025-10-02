@extends('dashboard.core.app')
@section('title', __('dashboard.users'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- BreadCrumb -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.users') }}" :breadcrumbs="[['name' => __('dashboard.users'), 'route' => 'users.index'], ['name' => __('dashboard.Create')]]" />
        <!-- BreadCrumb -->

        <!-- Page Card -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>
            <x-form.form-component :route="route('users.store')" method="POST">
                <input hidden name="company_id" value="{{ request('company') }}">
                <x-input.input-field name="name" label="{{ __('dashboard.Name') }}" placeholder="{{ __('dashboard.Name') }}"
                    class="custom-class" id="nameInput" required="true" />

                <x-input.input-field name="email" type="email" label="{{ __('dashboard.Email') }}"
                    placeholder="{{ __('dashboard.Email') }}" required="true" />

                <x-input.input-field name="password" type="password" label="{{ __('dashboard.password') }}"
                    placeholder="{{ __('dashboard.password') }}" required="true" />

                <x-input.input-field name="password_confirmation" type="password"
                    label="{{ __('dashboard.password_confirmation') }}"
                    placeholder="{{ __('dashboard.password_confirmation') }}" required="true" />



                    <x-editor.summernote id="myEditor" label="{{ __('dashboard.about_us') }}" name="about_us_content" value="{{ old('about_us_content') }}" />


            </x-form.form-component>
        </x-cards.page-card>
        <!-- Page Card -->

    </div>
@endsection
