@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-20">
                <div class="card">
                    <div class="card-header">
                        Product Details
                    </div>

                    <div class="card-body">

                        <div class="row mb-4">
                            <div class="col-2">
                                <div class="menu-card-img-border">
                                    <img class="card-img-top menu-card-img" src="{{ $product->media_path ? asset($product->media_path) : asset('storage/defaults/product.png') }}" alt="{{ $product->name }}" title="{{ $product->description }}">
                                </div>
                            </div>
                            <div class="col-5">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Product Name</p>
                                        <p class="mb-0">{{ $product->name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Category</p>
                                        <p class="mb-0">{{ $product->productCategory->name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Description</p>
                                        <p class="mb-0">{{ $product->description }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Price</p>
                                        <p class="mb-0">{{ config('payment.currency_symbol') }}{{ $product->price }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Barcode</p>
                                        <p class="mb-0">{{ $product->barcode }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Status</p>
                                        <p class="mb-0">{{ $product->status ? 'Available' : 'Not Available' }}</p>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-5">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Store Name</p>
                                        <p class="mb-0">{{ $product->store->name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Description</p>
                                        <p class="mb-0">{{ $product->store->description }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Food Seller Name</p>
                                        <p class="mb-0">{{ $product->store->user->first_name }} {{ $product->store->user->last_name }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <p class="mb-0">Food Seller Username</p>
                                        <p class="mb-0">{{ $product->store->user->username }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">

                                <div class="card">
                                    <div class="card-header">
                                        Product Options
                                    </div>

                                    <div class="card-body">

                                        <div class="row row-cols-4">
                                            @foreach($product->productOptions as $option)
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            {{ $option->name }}
                                                        </div>

                                                        <div class="card-body">
                                                            <ul class="list-group">
                                                                @foreach($option->optionDetails as $detail)
                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                        <p class="mb-0">{{ $detail->name }}</p>
                                                                        <p class="mb-0">{{ $detail->extra_price }}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">

                                <div class="card">
                                    <div class="card-header">
                                        Orders include this product
                                    </div>

                                    <div class="card-body">

                                        <table class="dataTable table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Student Number</th>
                                                    <th>Student Name</th>
                                                    <th>Pick Up Time</th>
                                                    <th>Amount({{ config('payment.currency_symbol') }})</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->orderDetails as $orderDetail)
                                                    <tr>
                                                        <td>{{ $orderDetail->order->student->student_number }}</td>
                                                        <td>{{ $orderDetail->order->student->first_name }} {{ $orderDetail->order->student->last_name }}</td>
                                                        <td>{{ $orderDetail->order->pick_up_start->format('Y/m/d h:ia') }} to {{ $orderDetail->order->pick_up_end->format('Y/m/d h:ia') }}</td>
                                                        <td>{{ $orderDetail->order->total_price }}</td>
                                                        <td>{{ $orderDetail->order->getStatusString() }}</td>
                                                        <td>{{ $orderDetail->order->created_at->format('Y/m/d h:ia') }}</td>
                                                        <td>
                                                            <a class="btn btn-primary" href="{{ route('admin.order.details', ['order_id' => $orderDetail->order->id]) }}">Detail</a>
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
                                <a class="btn btn-primary" href="{{ route('admin.menus.list') }}">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
