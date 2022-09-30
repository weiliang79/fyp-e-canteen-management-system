@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              Product Category
                              <a href="{{ route('admin.menus.category.create') }}" class="btn btn-primary">New Category</a>
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th style="width: 20%;">Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($categories as $category)
                                          <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('admin.menus.category.edit', [$category->id]) }}">Edit</a>
                                                      <button type="button" class="btn btn-danger" onclick="promptDeleteWarning(this)" data-id="{{ $category->id }}">Delete</button>
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
                  html: 'Delete this category?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {

                        axios.post(
                            '{{ route("admin.menus.category.delete") }}',
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
