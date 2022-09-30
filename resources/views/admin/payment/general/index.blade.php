@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center mb-4">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Payment
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> The form has some error, please refill and submit again.
                                    </div>
                              </div>
                              @endif

                              <form action="{{ route('admin.payment.general.save') }}" method="post">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Currency Symbol</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-dollar-sign fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" name="currency_symbol" value="{{ old('currency_symbol', config('payment.currency_symbol')) }}" placeholder="Currency Symbol">
                                                      @error('currency_symbol')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                                <small class="form-text text-muted">*The symbol will be shown in the pages that has price tag.</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Maintenance Mode</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-wrench fa-fw"></i>
                                                      </div>

                                                      <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                                            <input type="checkbox" class="form-check-input" role="switch" name="maintenance" id="" {{ old('maintenance') || (!old('maintenance') && config('payment.maintenance_mode') == true) ? 'checked' : '' }}>
                                                      </div>
                                                </div>
                                                <small class="form-text text-muted">*When enabled, the payment method will be disabled to prevent further transactions.</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">2C2P</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <img src="{{ asset('storage/defaults/2C2P_Logo/PNG/2C2P_Logo_RGB_White_edit.png') }}" alt="" style="width: 25px; height: 7px;filter: invert(100%);">
                                                      </div>

                                                      <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                                            <input type="checkbox" class="form-check-input" role="switch" name="status_2c2p" id="" {{ old('status_2c2p') || (!old('status_2c2p') && config('payment.2c2p-status') == true) ? 'checked' : '' }}>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Stripe</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-brands fa-stripe fa-fw"></i>
                                                      </div>

                                                      <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                                            <input type="checkbox" class="form-check-input" role="switch" name="stripe_status" id="" {{ old('stripe_status') || (!old('stripe_status') && config('payment.stripe-status') == true) ? 'checked' : '' }}>
                                                      </div>
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
                                                <small class="form-text text-muted">*If nothing changes after submission, please restart the server.</small>
                                          </div>
                                    </div>


                              </form>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection