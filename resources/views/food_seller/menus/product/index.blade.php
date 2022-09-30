@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              Product list
                              <a class="btn btn-primary" href="{{ route('food_seller.menus.product.create') }}">Create new Product</a>
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Price ({{ config('payment.currency_symbol') }})</th>
                                                <th>Status</th>
                                                <th style="width: 20%;">Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($products as $product)
                                          <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->productCategory->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->status ? 'Available' : 'Not Available' }}</td>
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
                          '{{ route("food_seller.menus.product.delete") }}',
                          {
                              id: $(item).data('id'),
                          }
                          )
                          .then(function (response) {
                              SwalWithBootstrap.fire({
                                  title: 'Success',
                                  html: response.data,
                                  icon: 'success',
                              }).then((result) => {
                                  window.location.reload();
                              });
                          })
                          .catch(function (error) {
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
