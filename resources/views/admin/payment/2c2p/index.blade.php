@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center mb-4">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              2C2P Payment
                        </div>

                        <div class="card-body">

                            @if($errors->any())
                                <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                        <i class="fa-solid fa-circle-exclamation fa-lg"></i> The form has some error, please refill and submit again.
                                    </div>
                                </div>
                            @endif

                              <form action="{{  route('admin.payment.2c2p.save') }}" method="post">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Sandbox Mode</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-flask-vial fa-fw"></i>
                                                      </div>

                                                      <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                                            <input type="checkbox" class="form-check-input" role="switch" name="sandbox" id="" {{ old('sandbox') || (!old('sandbox') && config('payment.2c2p-sandbox.status') == true) ? 'checked' : '' }}>
                                                      </div>
                                                </div>
                                          </div>

                                          @if(config('payment.2c2p-sandbox.status'))
                                          <div class="col-md-3"></div>
                                          <div class="col-md-8 mt-3">
                                                <div class="card">
                                                      <div class="card-body">
                                                            <p class="mb-1">The sandbox mode will be access the 2C2P test system and followed the demo account below:</p>
                                                            <table>
                                                                  <tr>
                                                                        <td style="text-align: right;">Country/Region: </td>
                                                                        <td>Malaysia</td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td style="text-align: right;">Currency Code: </td>
                                                                        <td>{{ config('payment.2c2p-sandbox.currencyCode') }}</td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td style="text-align: right;">Merchant ID: </td>
                                                                        <td>{{ config('payment.2c2p-sandbox.merchantID') }}</td>
                                                                  </tr>
                                                            </table>
                                                            <p class="mb-1">It can be reference at: <a href="https://developer.2c2p.com/docs/sandbox">2C2P Developer Docs - Sandbox</a></p>
                                                            <p class="mb-1">The test cards / accounts for Malaysia merchants can be reference at: <a href="https://developer.2c2p.com/docs/reference-test-information-my">2C2P Developer Docs - Malaysia Test Cards / Accounts</a></p>
                                                      </div>
                                                </div>
                                          </div>
                                          @endif
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Merchant ID</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-cash-register fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('merchant_id') is-invalid @enderror" name="merchant_id" placeholder="Merchant ID" value="{{ old('merchant_id', config('payment.2c2p.merchantID')) }}" {{ config('payment.2c2p-sandbox.status') ? 'disabled' : '' }}>
                                                        @error('merchant_id')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                          </span>
                                                        @enderror
                                                </div>
                                                <small class="form-text text-muted">*Merchant ID is provided by 2C2P</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Currency Code</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-dollar-sign fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('currency_code') is-invalid @enderror" name="currency_code" placeholder="Currency Code" value="{{ old('currency_code', config('payment.2c2p.currencyCode')) }}" {{ config('payment.2c2p-sandbox.status') ? 'disabled' : '' }}>
                                                    @error('currency_code')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                    @enderror
                                                </div>
                                                <small class="form-text text-muted">*Currency Code is provided by 2C2P</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Secret Code</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-key fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('secret_code') is-invalid @enderror" name="secret_code" placeholder="Secret Code" value="{{ old('secret_code', config('payment.2c2p.secretCode')) }}" {{ config('payment.2c2p-sandbox.status') ? 'disabled' : '' }}>
                                                    @error('secret_code')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                    @enderror
                                                </div>
                                                <small class="form-text text-muted">*Secret Code is provided by 2C2P</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">Locale</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-earth-asia fa-fw"></i>
                                                      </div>

                                                      <select class="form-control @error('locale_code') is-invalid @enderror" name="locale_code" id="" {{ config('payment.2c2p-sandbox.status') ? 'disabled' : '' }}>
                                                            @if($locale)
                                                            @foreach($locale as $local)
                                                            <option value="{{ $local->code }}">{{ $local->name }}</option>
                                                            @endforeach
                                                            @endif
                                                      </select>

                                                    @error('locale_code')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                    @enderror
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
                  <small class="d-flex justify-content-center">
                        Powered by 2C2P
                  </small>
            </div>
      </div>
</div>

@endsection
