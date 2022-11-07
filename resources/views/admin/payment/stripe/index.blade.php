@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center mb-4">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    {{ __('Stripe Payment') }}
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.payment.stripe.save') }}" method="post">
                        @csrf

                        <div class="row mb-3">
                            <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Sandbox / Test Mode') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                        <i class="fa-solid fa-flask-vial fa-fw"></i>
                                    </div>

                                    <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                        <input type="checkbox" class="form-check-input" role="switch" name="sandbox" {{ old('sandbox') || (!old('sandbox') && config('payment.2c2p-sandbox.status') == true) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <small class="form-text text-muted">{{ __('*Please ensure that the mode is selected correctly and matched the keys below. More info at ') }}<a href="https://stripe.com/docs/keys#test-live-modes">{{ __('Stripe Docs - Test and live mode overview') }}</a></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Publishable Key') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                        <i class="fa-solid fa-key fa-fw"></i>
                                    </div>

                                    <input type="text" class="form-control @error('stripe_key') is-invalid @enderror" name="stripe_key" placeholder="Publishable Key">
                                    @error('stripe_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">{{ __('*Publishable Key is provided by Stripe.') }}</small><br>
                                <small class="form-text text-muted">{{ __('**Please ensure that the key entered are correctly either is a test key or live key. It can be find at ') }}<a href="https://dashboard.stripe.com/login">{{ __('Stripe Dashboard') }}</a>{{ __('. More info at ') }}<a href="https://stripe.com/docs/keys">{{ __('Stripe Docs - API Keys') }}</a></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Secret Key') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                        <i class="fa-solid fa-key fa-fw"></i>
                                    </div>

                                    <input type="text" class="form-control @error('stripe_secret') is-invalid @enderror" name="stripe_secret" placeholder="Secret Key">
                                    @error('stripe_secret')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">{{ __('*Secret Key is provided by Stripe.') }}</small><br>
                                <small class="form-text text-muted">{{ __('**Please ensure that the key entered are correctly either is a test key or live key. It can be find at ') }}<a href="https://dashboard.stripe.com/login">{{ __('Stripe Dashboard') }}</a>{{ __('. More info at ') }}<a href="https://stripe.com/docs/keys">{{ __('Stripe Docs - API Keys') }}</a></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Currency Code') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                        <i class="fa-solid fa-dollar-sign fa-fw"></i>
                                    </div>

                                    <input type="text" class="form-control @error('currency_code') is-invalid @enderror" name="currency_code" value="{{ old('currency_code', config('cashier.currency')) }}" placeholder="Currency Code">
                                    @error('currency_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">{{ __('*Currency Code is followed by ISO 4217, and can reference on ') }}<a href="https://stripe.com/docs/currencies">{{ __('Stripe Docs - Supported Currencies') }}</a>{{ __('.') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-8">
                                 <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 6%;">
                                        <i class="fa-solid fa-quote-right fa-fw"></i>
                                    </div>

                                    <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ $configStripe->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                            <div class="col-md-8 offset-md-3">
                                <small class="form-text text-muted">{{ __('*If nothing changes after submission, please restart the server.') }}</small>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
            <small class="d-flex justify-content-center">
                {{ __('Powered by Stripe, Inc.') }}
            </small>
        </div>
    </div>
</div>

@endsection