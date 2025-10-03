@extends('dashboard.core.app')
@section('title', __('dashboard.Banks'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Banks') }}" :breadcrumbs="[['name' => __('dashboard.Banks'), 'route' => 'banks.index'], ['name' => __('dashboard.Edit')]]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Edit') @lang('dashboard.Bank')
                </div>
            </x-slot>
            <x-form.form-component :route="route('banks.update', $bank->id)" method="PUT">
                <div class="row">
                    <div class="col-md-6">
                        <x-input.input-field name="name_en" label="{{ __('dashboard.Bank Name (English)') }}"
                            placeholder="{{ __('dashboard.Enter bank name in English') }}" required="true"
                            value="{{ $bank->name_en }}" />
                    </div>

                    <div class="col-md-6">
                        <x-input.input-field name="name_ar" label="{{ __('dashboard.Bank Name (Arabic)') }}"
                            placeholder="{{ __('dashboard.Enter bank name in Arabic') }}" required="true"
                            value="{{ $bank->name_ar }}" />
                    </div>

                    <div class="col-md-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                {{ $bank->is_active ? 'checked' : '' }}>
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
