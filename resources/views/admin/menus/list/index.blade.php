@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-20">
                <div class="card">
                    <div class="card-header">
                        Product List
                    </div>

                    <div class="card-body">

                        <table class="dataTable table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Store Name</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Price({{ config('payment.currency_symbol') }})</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->store->name }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->status ? 'Available' : 'Not Available' }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('admin.menus.list.details', ['product_id' => $product->id]) }}">Detail</a>
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
