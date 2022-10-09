@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center mb-4">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              User Management
                              <a href="{{ route('admin.user_management.create') }}" class="btn btn-primary">New User</a>
                        </div>

                        <div class="card-body">
                              <table class="dataTable table table-striped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($users as $user)
                                          <tr>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                      @if($user->role->id == App\Models\Role::ROLE_ADMIN)
                                                      {{ __('Admin') }}
                                                      @elseif($user->role->id == App\Models\Role::ROLE_SELLER)
                                                      {{ __('Food Seller') }}
                                                      @else
                                                      {{ __('Error: Unknown Id') }}
                                                      @endif
                                                </td>
                                                <td>{{ $user->email ?: 'None' }}</td>
                                                <td>{{ $user->created_at->format('Y/m/d h:ia') }}</td>
                                                <td>{{ $user->updated_at->format('Y/m/d h:ia') }}</td>
                                                <td><button type="button" class="btn btn-danger" onclick="promptDeleteWarning(this)" data-user-id="{{ $user->id }}">Delete</button></td>
                                          </tr>
                                          @endforeach
                                    </tbody>
                              </table>
                        </div>
                  </div>
            </div>
      </div>

      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              Student Management
                              <div>
                                    <a href="{{ route('admin.user_management.student.rest_time') }}" class="btn btn-primary">Manage Rest Time</a>
                                    <a href="{{ route('admin.user_management.student.create') }}" class="btn btn-primary">New Student</a>
                              </div>
                        </div>

                        <div class="card-body">
                              <table class="dataTable table table-striped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Student Number</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($students as $student)
                                          <tr>
                                                <td>@if($student->is_a_sandbox_student) <i class="fa-solid fa-flask fa-fw"></i> @endif{{ $student->student_number }}</td>
                                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                <td>{{ $student->username }}</td>
                                                <td>{{ $student->email ?: 'None' }}</td>
                                                <td>{{ $student->phone ?: 'None' }}</td>
                                                <td>{{ $student->address ?: 'None' }}</td>
                                                <td>{{ $student->created_at }}</td>
                                                <td>{{ $student->updated_at }}</td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('admin.user_management.student.edit', ['id' => $student->id]) }}">Edit</a>
                                                      <button type="button" class="btn btn-danger" onclick="promptDeleteStudentWarning(this)" data-id="{{ $student->id }}">Delete</button>
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
                  html: 'Delete this user?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {

                      axios.post(
                          '{{ route("admin.user_management.delete") }}',
                          {
                              user_id: $(item).data('user_id'),
                          })
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

      function promptDeleteStudentWarning(item) {
            SwalWithBootstrap.fire({
                  title: 'Warning',
                  html: 'Delete this student?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true,
            }).then((result) => {
                  if (result.isConfirmed) {

                      axios.post(
                          '{{  route("admin.user_management.student.delete") }}',
                          {
                              student_id: $(item).data('id'),
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
