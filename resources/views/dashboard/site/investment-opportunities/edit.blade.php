@extends('dashboard.core.app')
@section('title', __('dashboard.Investment Opportunities'))
@section('content')
    <div class="container-fluid px-5 py-3">
        <x-breadcrumb.breadcrumb title="{{ __('dashboard.Investment Opportunities') }}" :breadcrumbs="[
            ['name' => __('dashboard.Investment Opportunities'), 'route' => 'investment-opportunities.index'],
            ['name' => __('dashboard.Edit')],
        ]" />

        <x-cards.page-card>
            <x-slot name="header">
                <div class="card-title">
                    @lang('dashboard.Edit') @lang('dashboard.Investment Opportunity')
                </div>
            </x-slot>
            <x-form.form-component :route="route('investment-opportunities.update', $opportunity->id)" method="PUT" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <x-input.input-field name="company_name" label="{{ __('dashboard.Company Name') }}"
                            placeholder="{{ __('dashboard.Enter company name') }}" required="true"
                            value="{{ $opportunity->company_name }}" />
                    </div>

                    <div class="col-md-6">
                        <label for="market" class="form-label">@lang('dashboard.Market') <span
                                class="text-danger">*</span></label>
                        <select name="market" id="market" class="form-select" required>
                            <option value="">@lang('dashboard.Select Market')</option>
                            <option value="saudi" {{ $opportunity->market == 'saudi' ? 'selected' : '' }}>
                                @lang('dashboard.Saudi Market')</option>
                            <option value="american" {{ $opportunity->market == 'american' ? 'selected' : '' }}>
                                @lang('dashboard.American Market')</option>
                            <option value="global" {{ $opportunity->market == 'global' ? 'selected' : '' }}>
                                @lang('dashboard.Global Market')</option>
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
                            <option value="energy" {{ $opportunity->sector == 'energy' ? 'selected' : '' }}>
                                @lang('dashboard.Energy')</option>
                            <option value="banking" {{ $opportunity->sector == 'banking' ? 'selected' : '' }}>
                                @lang('dashboard.Banking')</option>
                            <option value="technology" {{ $opportunity->sector == 'technology' ? 'selected' : '' }}>
                                @lang('dashboard.Technology')</option>
                            <option value="healthcare" {{ $opportunity->sector == 'healthcare' ? 'selected' : '' }}>
                                @lang('dashboard.Healthcare')</option>
                            <option value="real_estate" {{ $opportunity->sector == 'real_estate' ? 'selected' : '' }}>
                                @lang('dashboard.Real Estate')</option>
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
                            <option value="low" {{ $opportunity->risk_level == 'low' ? 'selected' : '' }}>
                                @lang('dashboard.Low')</option>
                            <option value="medium" {{ $opportunity->risk_level == 'medium' ? 'selected' : '' }}>
                                @lang('dashboard.Medium')</option>
                            <option value="high" {{ $opportunity->risk_level == 'high' ? 'selected' : '' }}>
                                @lang('dashboard.High')</option>
                        </select>
                        @error('risk_level')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="current_price" label="{{ __('dashboard.Current Price') }}"
                            placeholder="{{ __('dashboard.Enter current price') }}" required="true" type="number"
                            step="0.01" min="0" value="{{ $opportunity->current_price }}" id="current_price" />
                    </div>

                    <div class="col-md-4">
                        <x-input.input-field name="entry_price" label="{{ __('dashboard.Entry Price') }}"
                            placeholder="{{ __('dashboard.Enter entry price') }}" required="true" type="number"
                            step="0.01" min="0" value="{{ $opportunity->entry_price }}" id="entry_price" />
                    </div>

                    <div class="col-md-4">
                        <label for="expected_return_percentage" class="form-label">
                            @lang('dashboard.Expected Return') (%)
                            <span class="text-muted small">(@lang('dashboard.Auto Calculated'))</span>
                        </label>
                        <input type="number" name="expected_return_percentage" id="expected_return_percentage"
                            class="form-control" step="0.01" readonly
                            value="{{ $opportunity->expected_return_percentage }}" placeholder="@lang('dashboard.Will be calculated automatically')">
                        @error('expected_return_percentage')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">@lang('dashboard.Description') <span
                                class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4" required
                            placeholder="{{ __('dashboard.Enter opportunity description') }}">{{ $opportunity->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="form-label">@lang('dashboard.Image')</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @if ($opportunity->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $opportunity->image) }}"
                                    alt="{{ $opportunity->company_name }}" width="100">
                            </div>
                        @endif
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_halal" id="is_halal"
                                value="1" {{ $opportunity->is_halal ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_halal">
                                @lang('dashboard.Is Halal?')
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                value="1" {{ $opportunity->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                @lang('dashboard.Is Active?')
                            </label>
                        </div>
                    </div>
                </div>
            </x-form.form-component>
        </x-cards.page-card>
    </div>

    @push('scripts')
        <script>
            function calculateExpectedReturn() {
                var currentPrice = parseFloat($('#current_price').val()) || 0;
                var entryPrice = parseFloat($('#entry_price').val()) || 0;

                if (entryPrice > 0) {
                    // حساب النسبة: ((السعر الحالي - سعر الدخول) / سعر الدخول) * 100
                    var returnPercentage = ((currentPrice - entryPrice) / entryPrice) * 100;
                    $('#expected_return_percentage').val(returnPercentage.toFixed(2));
                } else {
                    $('#expected_return_percentage').val('');
                }
            }

            $(document).ready(function() {
                // Calculate on page load
                calculateExpectedReturn();

                // Calculate on input change
                $('#current_price, #entry_price').on('input change', function() {
                    calculateExpectedReturn();
                });
            });
        </script>
    @endpush
@endsection
