@extends('dashboard.core.app')
@section('title', __('dashboard.roles_and_permissions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ $role->t('display_name') }}" :breadcrumbs="[
            ['name' => __('dashboard.roles_and_permissions'), 'route' => 'roles.index'],
            ['name' => $role->t('display_name'), 'route' => 'roles.mangers', 'params' => ['id' => $role->id]],
            ['name' => __('dashboard.Edit Role')],
        ]" />
        <x-cards.page-card>

            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Edit Role')
                </div>
            </x-slot>

            <x-form.form-component :route="route('roles.update', $role->id)" method="PUT">

                <x-input.input-field name="display_name_ar" label="{{ __('dashboard.Name') }} {{ __('dashboard.ar') }}"
                    placeholder="{{ __('dashboard.Name') }} {{ __('dashboard.ar') }}" value="{{ $role->display_name_ar }}"
                    required="true" />

                <x-input.input-field name="display_name_en" label="{{ __('dashboard.Name') }} {{ __('dashboard.en') }}"
                    placeholder="{{ __('dashboard.Name') }} {{ __('dashboard.en') }}" value="{{ $role->display_name_en }}"
                    required="true" />

                <div class="form-group row">
                    <h4 class="card-title my-4">@lang('dashboard.Permissions')</h4>
                    @foreach ($permissions as $key => $permission)
                        <div class="col-6">
                            <div class="form-check m-3">
                                <input {{ $role->hasPermission($permission->name) ? 'checked' : '' }} type="checkbox"
                                    name="permissions[]" value="{{ $permission->id }}" class="form-check-input"
                                    id="{{ $key }}" />
                                <label class="form-check-label" for="{{ $key }}">{{ $permission->display_name }}
                                </label>
                            </div>
                            <hr>
                        </div>
                    @endforeach

                    {{-- <div class="d-flex align-items-center flex-wrap mb-3">
                                <div
                                    class="toggle toggle-secondary {{ $role->hasPermission($permission->name) ? 'on' : '' }} mb-0">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        id="permission-{{ $key }}" class="d-none"
                                        {{ $role->hasPermission($permission->name) ? 'checked' : '' }}>
                                    <span onclick="toggleCheckbox('permission-{{ $key }}')"></span>
                                </div>
                                <div>
                                    <p class="text-muted m-2">{{ $permission->display_name }}</p>
                                </div>
                            </div> --}}
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
