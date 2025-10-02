<a href="javascript:void(0);" class="btn btn-icon btn-outline-danger btn-delete" data-route="{{ $route }}"
    data-id="{{ $itemId }}" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-danger" data-bs-placement="top"
    title="@lang('dashboard.delete')">
    <i class="ri-delete-bin-line"></i>
</a>

@include('dashboard.core.alerts.sweet-alert.delete')
