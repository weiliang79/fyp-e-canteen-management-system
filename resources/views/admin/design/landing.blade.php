@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Design: Landing Page
                        </div>

                        <div class="card-body">

                            @if($errors->any())
                                <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                        <i class="fa-solid fa-circle-exclamation fa-lg"></i> The form has some error, please refill and submit again.
                                    </div>
                                </div>
                            @endif

                                <form action="{{ route('admin.design.landing.update') }}" method="POST">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Banner Image') }}</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                    <i class="fa-solid fa-chalkboard fa-fw"></i>
                                                </div>

                                                <input id="banner_path" class="form-control @error('banner_path') is-invalid @enderror" type="text" name="banner_path" value="{{ old('banner_path', $design ? $design->banner_path : '') }}" placeholder="Banner Image Path">
                                                <button class="btn btn-primary" id="lfm" data-input="banner_path" data-preview="holder">Choose Image</button>

                                                @error('banner_path')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- image preview --}}
                                    <div class="row mb-3 justify-content-center">
                                        <div class="col-1" id="holder">

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Slogan') }}</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%;">
                                                    <i class="fa-solid fa-heading fa-fw"></i>
                                                </div>

                                                <input type="text" class="form-control @error('slogan') is-invalid @enderror" name="slogan" value="{{ old('slogan', $design ? $design->slogan : '') }}" placeholder="Slogan">

                                                @error('slogan')
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
                                                <div class="input-group-text justify-content-center" style="width: 6%">
                                                    <i class="fa-solid fa-quote-right fa-fw"></i>
                                                </div>

                                                <textarea name="description" id="description_editor" class="form-control" cols="30" rows="10">{{ $design ? $design->description : '' }}</textarea>
                                                <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
                                                <script>
                                                    var options = {
                                                        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                                                        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                                                        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                                                        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                                                    };

                                                    window.addEventListener('DOMContentLoaded', function () {
                                                        CKEDITOR.replace('description_editor', options);
                                                    });
                                                </script>

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
