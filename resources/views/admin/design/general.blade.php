@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Design: General') }}
                        </div>

                        <div class="card-body">

                              <form action="{{ route('admin.design.general.update') }}" method="POST">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('App Icon') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-icons fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('app_icon_path') is-invalid @enderror" id="app_icon_path" name="app_icon_path" value="{{ old('app_icon_path', $designs->where('name', 'app_icon')->count() !== 0 ? (\App\Models\GeneralDesign::where('name', 'app_icon')->first()->path !== null ? Request::root() . '/' . $designs->where('name', 'app_icon')->first()->path : '') : '' ) }}" placeholder="Icon Image Path">
                                                      <button class="btn btn-primary" type="button" id="lfm" data-input="app_icon_path" data-preview="holder">Choose Image</button>

                                                      @error('app_icon_path')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                                <small class="form-text text-muted">{{ __('*The icon size should be 16px*16px and is .ico type.') }}</small>
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