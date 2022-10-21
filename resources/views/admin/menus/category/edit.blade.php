@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Product Category') }}
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('The form has some error, please refill and submit again.') }}
                                    </div>
                              </div>
                              @endif

                              <form action="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.menus.category.create') ? route('admin.menus.category.save') : route('admin.menus.category.update') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $category !== null ? $category->id : '' }}">

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Product Category Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-tag fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category !== null ? $category->name : '') }}" placeholder="Product Category Name">

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

                                                      <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="" cols="30" rows="10">{{ old('description', $category !== null ? $category->description : '') }}</textarea>

                                                      @error('description')
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