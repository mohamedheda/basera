@extends('dashboard.core.app')
@section('title', __('dashboard.Create'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Create') }}" :breadcrumbs="[
            ['name' => __('dashboard.roles_and_permissions'), 'route' => 'roles.index'],
            ['name' => __('dashboard.Create')],
        ]" />
        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create')
                </div>
            </x-slot>

            <x-form.form-component :route="route('roles.store')">


                <x-input.input-field name="display_name_ar" label="{{ __('dashboard.Name') }} {{ __('dashboard.ar') }}"
                    placeholder="{{ __('dashboard.Name') }} {{ __('dashboard.ar') }}" required="true" />

                <x-input.input-field name="display_name_en" label="{{ __('dashboard.Name') }} {{ __('dashboard.en') }}"
                    placeholder="{{ __('dashboard.Name') }} {{ __('dashboard.en') }}" required="true" />

                <div class="form-group row">
                    <h4 class="card-title my-4">@lang('dashboard.Permissions')</h4>
                    @foreach ($permissions as $key => $permission)
                        <div class="col-6">
                            <div class="form-check m-3">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="form-check-input" id="{{ $key }}" />
                                <label class="form-check-label" for="{{ $key }}">{{ $permission->display_name }}
                                </label>
                            </div>
                            <hr>
                        </div>
                    @endforeach


            </x-form.form-component>

        </x-cards.page-card>
    </div>
@endsection
@section('js_addons')
    <script>
        function toggleCheckbox(id) {
            let checkbox = document.getElementById(id);
            checkbox.checked = !checkbox.checked;
        }
    </script>
@endsection
