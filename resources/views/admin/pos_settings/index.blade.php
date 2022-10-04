@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              POS Settings
                        </div>

                        <div class="card-body">

                              <form action="{{ route('admin.pos_settings.store') }}" method="POST">
                              @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('POS App Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-cash-register fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="{{ old('app_name', $settings->where('key', 'app_name')->first()->value) }}" placeholder="POS App Name">
                                                
                                                      @error('app_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Currency Symbol') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-dollar-sign fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" name="currency_symbol" value="{{ old('app_name', $settings->where('key', 'currency_symbol')->first()->value) }}" placeholder="Currency Symbol">

                                                      @error('app_name')
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
                                    </div>

                              </form>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection