@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    {{ __('Product List') }}
                </div>

                <div class="card-body">

                    <table class="dataTable table table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('Store Name') }}</th>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ 'Price(' . config('payment.currency_symbol') . ')' }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->store->name }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}" style="font-size: 0.8rem;">
                                        {{ $product->status ? 'Available' : 'Not Available' }}
                                    </span>
                                </td>
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