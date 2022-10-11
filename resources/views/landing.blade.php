@extends('layouts.student.app_public')

@section('content')

<div class="container-fluid">
      <div class="row">
            <div class="col p-0">
                  <div class="banner">
                        <img class="banner-img" src="{{ asset('/storage/defaults/canteen-banner.png') }}" alt="" style="width: 100%;">
                        <div class="banner-text">
                              <h1>{{ config('app.name') }}</h1>
                              <h4>test</h4>
                        </div>
                  </div>
            </div>
      </div>

      <div class="row">
            <div class="col">

            </div>
      </div>
</div>

@endsection