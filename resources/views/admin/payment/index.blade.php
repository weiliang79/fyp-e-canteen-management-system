@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              Payment
                              <a class="btn btn-primary" href="{{ route('admin.payment.create') }}">Create New Payment</a>
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
                                          @foreach($types as $type)
                                          <tr>
                                                <td>{{ $type->name }}</td>
                                                <td>{{ $type->description }}</td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('admin.payment.edit', $type->id) }}">Edit</a>
                                                      <button type="button" class="btn btn-danger" onclick="promptDeleteWarning(this)" data-id="{{ $type->id }}">Delete</button>
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
                  html: 'Delete this payment type?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {

                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                        });

                        $.ajax({
                              url: '{{ route("admin.payment.delete") }}',
                              method: 'POST',
                              dataType: 'json',
                              data: {
                                    id: $(item).data('id'),
                              },
                              success: function(result) {
                                    SwalWithBootstrap.fire({
                                          title: 'Success',
                                          html: result,
                                          icon: 'success',
                                    }).then((result) => {
                                          window.location.reload();
                                    });
                              },
                              error: function(error) {
                                    console.log(error);
                              }

                        });
                  } else if (result.dismiss === Swal.DismissReason.cancel) {

                  }
            });
      }
</script>
@endsection