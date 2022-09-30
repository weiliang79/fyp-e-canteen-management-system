@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header">
                              Payment
                        </div>

                        <div class="card-body">

                              <form action="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.payment.create') ? route('admin.payment.save') : route('admin.payment.update') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $type !== null ? $type->id : '' }}">

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Payment Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-credit-card fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $type !== null ? $type->name : '') }}" placeholder="Payment Name">

                                                      @error('name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-quote-right fa-fw"></i>
                                                      </div>

                                                      <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ old('description', $type !== null ? $type->description : '') }}</textarea>

                                                      @error('name')
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