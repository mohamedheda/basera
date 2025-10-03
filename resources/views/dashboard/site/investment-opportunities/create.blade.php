@extends('dashboard.core.app')
@section('title', __('dashboard.Investment Opportunities'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Investment Opportunities') }}" :breadcrumbs="[
            ['name' => __('dashboard.Investment Opportunities'), 'route' => 'investment-opportunities.index'],
            ['name' => __('dashboard.Create')],
        ]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Create') @lang('dashboard.Investment Opportunity')
                </div>
            </x-slot>
            <x-form.form-component :route="route('investment-opportunities.store')" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <x-input.input-field name="company_name" label="{{ __('dashboard.Company Name') }}"
                            placeholder="{{ __('dashboard.Enter company name') }}" required="true" />
                    </div>

                    <div class="col-md-6">
                        <label for="market" class="form-label">@lang('dashboard.Market') <span
                                class="text-danger">*</span></label>
                        <select name="market" id="market" class="form-select" required>
                            <option value="">@lang('dashboard.Select Market')</option>
                            <option value="saudi">@lang('dashboard.Saudi Market')</option>
                            <option value="american">@lang('dashboard.American Market')</option>
                            <option value="global">@lang('dashboard.Global Market')</option>
                        </select>
                        @error('market')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="sector" class="form-label">@lang('dashboard.Sector') <span
                                class="text-danger">*</span></label>
                        <select name="sector" id="sector" class="form-select" required>
                            <option value="">@lang('dashboard.Select Sector')</option>
                            <option value="energy">@lang('dashboard.Energy')</option>
                            <option value="banking">@lang('dashboard.Banking')</option>
                            <option value="technology">@lang('dashboard.Technology')</option>
                            <option value="healthcare">@lang('dashboard.Healthcare')</option>
                            <option value="real_estate">@lang('dashboard.Real Estate')</option>
                        </select>
                        @error('sector')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="risk_level" class="form-label">@lang('dashboard.Risk Level') <span
                                class="text-danger">*</span></label>
                        <select name="risk_level" id="risk_level" class="form-select" required>
                            <option value="">@lang('dashboard.Select Risk Level')</option>
                            <option value="low">@lang('dashboard.Low')</option>
                            <option value="medium">@lang('dashboard.Medium')</option>
                            <option value="high">@lang('dashboard.High')</option>
                        </select>
                        @error('risk_level')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="current_price" label="{{ __('dashboard.Current Price') }}"
                            placeholder="{{ __('dashboard.Enter current price') }}" required="true" type="number"
                            step="0.01" min="0" />
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="entry_price" label="{{ __('dashboard.Entry Price') }}"
                            placeholder="{{ __('dashboard.Enter entry price') }}" required="true" type="number"
                            step="0.01" min="0" />
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="expected_return_percentage"
                            label="{{ __('dashboard.Expected Return') }}"
                            placeholder="{{ __('dashboard.Enter expected return %') }}" required="true" type="number"
                            step="0.01" min="0" max="100" />
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">@lang('dashboard.Description') <span
                                class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4" required
                            placeholder="{{ __('dashboard.Enter opportunity description') }}"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="form-label">@lang('dashboard.Image')</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_halal" id="is_halal" value="1"
                                checked>
                            <label class="form-check-label" for="is_halal">
                                @lang('dashboard.Is Halal?')
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                value="1" checked>
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
