@extends('dashboard.core.app')
@section('title', __('dashboard.managers'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Manager') }}" :breadcrumbs="[['name' => __('dashboard.Manager')], ['name' => __('dashboard.Edit')]]" />



        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>

            <x-form.form-component :route="route('managers.update', $manager->id)" method="PUT">
                <input type="hidden" name="id" value="{{ $manager->id }}">
                <input type="hidden" name="role_id" value=" {{ $role->id }}" />
                <x-input.input-field name="name" label="{{ __('dashboard.Name') }}"
                    placeholder="{{ __('dashboard.Name') }}" class="custom-class" id="name" required="true"
                    value="{{ $manager->name }}" />

                <x-input.input-field name="email" type="email" label="{{ __('dashboard.Email') }}"
                    placeholder="{{ __('dashboard.Email') }}" required="true" value="{{ $manager->email }}" />

                <x-input.input-field name="phone" type="phone" label="{{ __('dashboard.Phone') }}"
                    placeholder="{{ __('dashboard.Phone') }}" required="true" value="{{ $manager->phone }}" />

                <div class="row mt-3">
                    <x-input.input-field name="password" type="password" label="{{ __('dashboard.password') }}"
                        placeholder="{{ __('dashboard.password') }}" />

                    <x-input.input-field name="password_confirmation" type="password"
                        label="{{ __('dashboard.password_confirmation') }}"
                        placeholder="{{ __('dashboard.password_confirmation') }}" />
                </div>
                <div class="row mt-3">
                    <x-input.input-field class="" type="checkbox" name="is_active" id="is_active"
                        label="{{ __('dashboard.Activate') }}" value="{{ $manager->is_active }}" />
                </div>
                <div class="row mt-3">
                    <x-input.input-field name="image" type="file" label="{{ __('dashboard.Image') }}" />
                    @if ($manager->image)
                        <img src="@image($manager->image)" style="width: 250px;" />
                    @endif
                </div>

            </x-form.form-component>

        </x-cards.page-card>
    </div>
@endsection
@section('js_addons')

@endsection
