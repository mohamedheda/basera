@extends('dashboard.core.app')
@section('title', __('dashboard.roles_and_permissions'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.roles_and_permissions') }}" :breadcrumbs="[['name' => __('dashboard.roles_and_permissions'), 'route' => 'roles.index']]" />
        <!-- Page Header Close -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.roles_and_permissions')
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <button class="btn btn-outline-primary btn-wave waves-effect waves-light me-1" data-bs-toggle="modal"
                            data-bs-target="#c">
                            <i class="ti ti-search"></i>
                        </button>
                        <x-buttons.create-button :route="route('roles.create')" />

                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('dashboard.Name')</th>
                            <th>@lang('dashboard.Managers_Count')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr id="row-{{ $role->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->t('display_name') }}</td>
                                <td>{{ $role->managersCount }}</td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        @permission('managers-read')
                                            <x-buttons.show-button :route="route('roles.mangers', $role->id)" />
                                        @endpermission
                                        @permission('roles-update')
                                            <x-buttons.edit-button :route="route('roles.edit', $role->id)" />
                                        @endpermission
                                        @permission('roles-delete')
                                            <x-buttons.delete-button :route="route('roles.destroy', $role->id)" :itemId="$role->id" />
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('dashboard.core.includes.no-entries', ['columns' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot name="footer">
                <div class="d-flex justify-content-end align-items-center">
                    {{ $roles->links() }}
                </div>
            </x-slot>
        </x-cards.page-card>
    </div>
@endsection
@section('js_addons')

@endsection
