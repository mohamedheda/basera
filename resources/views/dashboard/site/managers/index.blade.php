@extends('dashboard.core.app')
@section('title', $role->t('display_name'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <!-- Page Header -->
        <x-breadcrumb.breadcrumb title="{{ $role->t('display_name') }}" :breadcrumbs="[
            ['name' => __('dashboard.roles_and_permissions'), 'route' => 'roles.index'],
            ['name' => $role->t('display_name'), 'route' => 'roles.index'],
            ['name' => __('dashboard.Create Admin')],
        ]" />
        <!-- Page Header Close -->
        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create Admin')
                </div>
                <div class="d-flex">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <button class="btn btn-outline-primary btn-wave waves-effect waves-light me-1" data-bs-toggle="modal"
                            data-bs-target="#c">
                            <i class="ti ti-search"></i>
                        </button>

                        <x-buttons.create-button :route="route('managers.create', $role->id)" />
                    </div>
                </div>
            </x-slot>
            <div class="table-responsive">
                <table class="table text-nowrap" id="managers_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 50px;">@lang('dashboard.Image')</th>
                            <th>@lang('dashboard.Name')</th>
                            <th>@lang('dashboard.Phone')</th>
                            <th>@lang('dashboard.Email')</th>
                            <th>@lang('dashboard.Activate')</th>
                            <th>@lang('dashboard.Operations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($managers as $manager)
                            <tr id="row-{{ $manager->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($manager->image !== null)
                                        <img src="@image($manager->image)" style="width: 50px;" />
                                    @endif
                                </td>
                                <td>{{ $manager->name }}</td>
                                <td>{{ $manager->phone }}</td>
                                <td>{{ $manager->email }}</td>
                                <td>
                                    <div class="custom-toggle-switch d-flex align-items-center">
                                        <input id="toggle_{{ $manager->id }}" name="toggleswitch_{{ $manager->id }}"
                                            type="checkbox" {{ $manager->is_active == 1 ? 'checked' : '' }}
                                            onclick="toggleManagerStatus({{ $manager->id }})">
                                        <label for="toggle_{{ $manager->id }}" class="label-secondary"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        @permission('managers-update')
                                            <x-buttons.edit-button :route="route('managers.edit', $manager->id)" />
                                        @endpermission
                                        @permission('managers-delete')
                                            <x-buttons.delete-button :route="route('managers.destroy', $manager->id)" :itemId="$manager->id" />
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('dashboard.core.includes.no-entries', ['columns' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot name="footer">
                <div class="d-flex justify-content-end align-items-center">
                    {{ $managers->links() }}
                </div>
            </x-slot>
        </x-cards.page-card>
    </div>
@endsection
@push('scripts')
    <script>
        function toggleManagerStatus(managerId) {
            let checkbox = document.getElementById(`toggle_${managerId}`);
            let isChecked = checkbox.checked ? 1 : 0;

            let routeUrl = `{{ route('managers.toggle', ['id' => '__id__']) }}`.replace('__id__', managerId);

            $.ajax({
                url: routeUrl,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    is_active: isChecked
                },
                success: function(response) {
                    console.log(response.message);

                    if (response.data && response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });

                    }
                },

                error: function(xhr, status, error) {
                    alert('An error occurred: ' + (xhr.responseJSON?.message || status));
                    checkbox.checked = !isChecked;
                }
            });
        }
    </script>
@endpush
