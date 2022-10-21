@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Store') }}
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('The form has some error, please refill and submit again.') }}
                                    </div>
                              </div>
                              @endif

                              <form method="POST" action="{{ route('food_seller.store.save') }}">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Store Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-store fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="{{ old('store_name', $store !== null ? $store->name : '') }}" placeholder="Store Name">

                                                      @error('store_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Store Logo') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-tag fa-fw"></i>
                                                      </div>

                                                      <input id="logo_path" class="form-control @error('logo_path') is-invalid @enderror" type="text" name="logo_path" value="{{ old('logo_path', $store !== null ? ($store->logo_path !== null ? Request::root() . '/' . $store->logo_path : '') : '') }}">
                                                      <button class="btn btn-primary" id="lfm" data-input="logo_path" data-preview="holder">Choose Image</button>

                                                      @error('logo_path')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    {{-- image preview --}}
                                    <div class="row mb-3 justify-content-center">
                                          <div class="col-1 " id="holder"></div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-quote-right fa-fw"></i>
                                                      </div>

                                                      <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ old('description', $store !== null ? $store->description : '') }}</textarea>

                                                      @error('store_name')
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