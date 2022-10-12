@extends('layouts.student.app_public')

@section('content')

<div class="container-fluid">
      <div class="row">
            <div class="col p-0">
                  <div class="banner">
                        <img class="banner-img" src="{{ $design !== null ? ($design->banner_path !== null ? asset('/' . $design->banner_path) : asset('/storage/defaults/canteen-banner.png') ) : asset('/storage/defaults/canteen-banner.png') }}" alt="" style="width: 100%;">
                        <div class="banner-text">
                              <h1>{{ config('app.name') }}</h1>
                              <h4>{{ $design !== null ? $design->slogan : '' }}</h4>
                        </div>
                  </div>
            </div>
      </div>

      @if($design !== null)
      @if($design->description !== null)
      <div class="row my-4">
            <div class="col">
                {!! $design !== null ? $design->description : '' !!}
            </div>
      </div>
      @endif
      @endif
</div>

@endsection
