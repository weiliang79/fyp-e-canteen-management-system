@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              {{ __('Design: Information Page') }}
                              <a href="{{ route('admin.design.information.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>{{ __('Title') }}</th>
                                                <th style="width: 20%;">{{ __('Action') }}</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($infos as $info)
                                          <tr>
                                                <td>{{ $info->title }}</td>
                                                <td>
                                                      <a href="{{ route('admin.design.information.edit', ['id' => $info->id]) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                                      <button type="button" class="btn btn-danger">{{ __('Delete') }}</button>
                                                </td>
                                          </tr>
                                          @endforeach
                                    </tbody>
                              </table>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection