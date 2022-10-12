@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Design: Information Page - Create
                        </div>

                        <div class="card-body">
                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> The form has some error, please refill and submit again.
                                    </div>
                              </div>
                              @endif

                              <form action="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.design.information.create') ? route('admin.design.information.store') : route('admin.design.information.update', ['id' => $info->id]) }}" method="POST">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Title') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-heading fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $info ? $info->title : '') }}" placeholder="Title">

                                                      @error('title')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Content') }}</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 6%">
                                                    <i class="fa-solid fa-quote-right fa-fw"></i>
                                                </div>

                                                <textarea name="content" id="description_editor" class="form-control" cols="30" rows="10">{{ $info ? $info->content : '' }}</textarea>
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