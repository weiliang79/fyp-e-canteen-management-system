@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header">
                              {{ $info->title }}
                        </div>

                        <div class="card-body">
                              {!! $info->content !!}
                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection