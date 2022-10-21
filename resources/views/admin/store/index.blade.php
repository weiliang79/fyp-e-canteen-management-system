@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Store') }}
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>{{ __('Food Seller Name') }}</th>
                                                <th>{{ __('Food Seller Username') }}</th>
                                                <th>{{ __('Store Name') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ __('Action') }}</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($stores as $store)
                                          <tr>
                                                <td>{{ $store->user->first_name }} {{ $store->user->last_name }}</td>
                                                <td>{{ $store->user->username }}</td>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ $store->description ?: 'None' }}</td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('admin.store.details', ['store_id' => $store->id]) }}">{{ __('Detail') }}</a>
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