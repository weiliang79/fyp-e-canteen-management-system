@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              {{ __('Product list') }}
                              <a class="btn btn-primary" href="{{ route('food_seller.menus.product.create') }}">{{ __('Create new Product') }}</a>
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Category') }}</th>
                                                <th>{{ 'Price(' . config('payment.currency_symbol') . ')' }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th style="width: 20%;">{{ __('Action') }}</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($products as $product)
                                          <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->productCategory->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                      <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}" style="font-size: 0.8rem;">
                                                            {{ $product->status ? 'Available' : 'Not Available' }}
                                                      </span>
                                                </td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('food_seller.menus.product.edit', ['id' => $product->id]) }}">Edit</a>
                                                      <button class="btn btn-danger" type="button" onclick="promptDeleteWarning(this)" data-id="{{ $product->id }}">Delete</button>
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

<script>
      function promptDeleteWarning(item) {
            SwalWithBootstrap.fire({
                  title: 'Warning',
                  html: 'Delete this Product?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {

                        axios.post(
                                    '{{ route("food_seller.menus.product.delete") }}', {
                                          id: $(item).data('id'),
                                    }
                              )
                              .then(function(response) {
                                    SwalWithBootstrap.fire({
                                          title: 'Success',
                                          html: response.data,
                                          icon: 'success',
                                    }).then((result) => {
                                          window.location.reload();
                                    });
                              })
                              .catch(function(error) {
                                    console.log(error);
                                    SwalWithBootstrap.fire({
                                          title: 'Error',
                                          html: error.message,
                                          icon: 'error',
                                    }).then((result) => {
                                          window.location.reload();
                                    });
                              });

                  } else if (result.dismiss === Swal.DismissReason.cancel) {

                  }
            });
      }
</script>

@endsection