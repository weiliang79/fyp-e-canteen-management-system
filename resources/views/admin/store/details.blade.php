@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    {{ __('Store Details') }}
                </div>

                <div class="card-body">

                    <div class="row justify-content-center mb-4">
                        <div class="col-2">
                            <div class="menu-card-img-border">
                                <img class="card-img-top menu-card-img" src="{{ $store->logo_path ? asset($store->logo_path) : asset('storage/defaults/store.png') }}" alt="{{ $store->name }}" title="{{ $store->description }}">
                            </div>
                        </div>

                        <div class="col-5">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Store Name') }}</p>
                                    <p class="mb-0">{{ $store->name }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Description') }}</p>
                                    <p class="mb-0">{{ $store->description ?: 'None' }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Food Seller Name') }}</p>
                                    <p class="mb-0">{{ $store->user->first_name . ' ' . $store->user->last_name }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Food Seller Username') }}</p>
                                    <p class="mb-0">{{ $store->user->username }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">

                            <div class="card">
                                <div class="card-header">
                                    {{ __('Product List') }}
                                </div>

                                <div class="card-body">

                                    <table class="dataTable table table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Product Name') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ 'Price(' . config('payment.currency_symbol') . ')' }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($store->products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    <span class="badge {{ $product->status ? 'bg-success' : 'bg-error' }}" style="font-size: 0.8rem;">
                                                        {{ $product->status ? 'Available' : 'Not Available' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{ route('admin.menus.list.details', ['product_id' => $product->id]) }}">{{ __('Detail') }}</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-3">
                            <a class="btn btn-primary" href="{{ route('admin.store') }}">{{ __('Back to Store list') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection