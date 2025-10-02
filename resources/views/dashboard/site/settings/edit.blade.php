@extends('dashboard.core.app')
@section('title', __('dashboard.Settings'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Settings') }}" :breadcrumbs="[['name' => __('dashboard.Settings')]]" />



        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.General_Info')
                </div>
            </x-slot>
            <x-form.form-component :route="route('settings.update', $user->id)" method="PUT" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $user->id }}">

                <x-input.input-field name="name" type="text" label="{{ __('dashboard.name') }}"
                    placeholder="{{ __('dashboard.name') }}" value="{{ $user->name }}" />
                <x-input.input-field name="phone" type="text" label="{{ __('dashboard.Phone') }}"
                    placeholder="{{ __('dashboard.Phone') }}" value="{{ $user->phone }}" />

                <x-input.input-field name="email" type="text" label="{{ __('dashboard.email') }}"
                    placeholder="{{ __('dashboard.email') }}" value="{{ $user->email }}" />

                <div class="row mt-3">
                    <x-input.input-field name="image" type="file" label="{{ __('dashboard.Image') }}" />
                    @if ($user->image)
                        <img src="@image($user->image)" style="width: 250px;" />
                    @endif
                </div>

            </x-form.form-component>


        </x-cards.page-card>






        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Change_Passwords')
                </div>
            </x-slot>

            <x-form.form-component :route="route('update-password')" method="POST">
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="row m-0">

                    <x-input.input-field wrapperClass="col-12 mb-3" name="current_password" type="password"
                        label="{{ __('dashboard.Current_Password') }}"
                        placeholder="{{ __('dashboard.Current_Password') }}" required="true" />
                </div>

                <div class="row m-0">

                    <x-input.input-field wrapperClass="col-12 mb-3" name="new_password" type="password"
                        label="{{ __('dashboard.New_Password') }}" placeholder="{{ __('dashboard.New_Password') }}" />

                </div>
                <div class="row m-0">

                    <x-input.input-field wrapperClass="col-12 mb-3" name="new_password_confirmation" type="password"
                        label="{{ __('dashboard.Confirm_New_Password') }}"
                        placeholder="{{ __('dashboard.Confirm_New_Password') }}" required="true" />
                </div>
            </x-form.form-component>


        </x-cards.page-card>
    </div>
@endsection
@section('js_addons')

@endsection
