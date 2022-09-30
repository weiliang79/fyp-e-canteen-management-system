@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              Store
                              <a href="{{ route('food_seller.store.edit') }}" class="btn btn-primary">Edit</a>
                        </div>

                        <div class="card-body">
                              <div class="row">
                                    <div class="col">
                                          {{ $store->name }}
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                          <img src="{{ $store->logo_path }}" width="100px" height="100px">
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col">
                                          {{ $store->description }}
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection