@extends('dashboard.core.app')
@section('title', __('dashboard.Subscription Packages'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Subscription Packages') }}" :breadcrumbs="[
            ['name' => __('dashboard.Subscription Packages'), 'route' => 'subscription-packages.index'],
            ['name' => __('dashboard.Edit')],
        ]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Edit') @lang('dashboard.Subscription Package')
                </div>
            </x-slot>
            <x-form.form-component :route="route('subscription-packages.update', $package->id)" method="PUT">
                <div class="row">
                    <div class="col-md-6">
                        <x-input.input-field name="name" label="{{ __('dashboard.Package Name') }}"
                            placeholder="{{ __('dashboard.Enter package name') }}" required="true"
                            value="{{ $package->name }}" />
                    </div>

                    <div class="col-md-6">
                        <label for="duration_type" class="form-label">@lang('dashboard.Duration Type') <span
                                class="text-danger">*</span></label>
                        <select name="duration_type" id="duration_type" class="form-select" required>
                            <option value="">@lang('dashboard.Select Duration Type')</option>
                            <option value="monthly" {{ $package->duration_type == 'monthly' ? 'selected' : '' }}>
                                @lang('dashboard.Monthly')</option>
                            <option value="semi_annual" {{ $package->duration_type == 'semi_annual' ? 'selected' : '' }}>
                                @lang('dashboard.Semi Annual')</option>
                            <option value="annual" {{ $package->duration_type == 'annual' ? 'selected' : '' }}>
                                @lang('dashboard.Annual')</option>
                        </select>
                        @error('duration_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="duration_months" label="{{ __('dashboard.Duration (Months)') }}"
                            placeholder="{{ __('dashboard.Enter duration in months') }}" required="true" type="number"
                            min="1" value="{{ $package->duration_months }}" />
                    </div>

                    <div class="col-md-3">
                        <x-input.input-field name="price" label="{{ __('dashboard.Price') }}"
                            placeholder="{{ __('dashboard.Enter price') }}" required="true" type="number" step="0.01"
                            min="0" value="{{ $package->price }}" />
                    </div>

                    <div class="col-md-3">
                        <x-input.input-field name="currency" label="{{ __('dashboard.Currency') }}"
                            placeholder="{{ __('dashboard.Enter currency') }}" required="true"
                            value="{{ $package->currency }}" />
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">@lang('dashboard.Description')</label>
                        <textarea name="description" id="description" class="form-control" rows="3"
                            placeholder="{{ __('dashboard.Enter package description') }}">{{ $package->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                {{ $package->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                @lang('dashboard.Is Active?')
                            </label>
                        </div>
                    </div>
                </div>
            </x-form.form-component>
        </x-cards.page-card>
    </div>

@endsection
