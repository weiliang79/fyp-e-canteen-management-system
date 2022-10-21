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

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Description') }}</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($categories as $category)
                                          <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
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