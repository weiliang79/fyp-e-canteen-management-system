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

                            <div class="row justify-content-center">
                                <div class="col-8">

                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <p class="mb-0">Store Name</p>
                                            <p class="mb-0">{{ $store->name }}</p>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <p class="mb-0">Description</p>
                                            <p class="mb-0">{{ $store->description }}</p>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <p class="mb-0">Store Logo</p>
                                            <img src="{{ $store->logo_path ? asset($store->logo_path) : asset('/storage/defaults/store.png') }}" alt="" style="width: 60px">
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection
