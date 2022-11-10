@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center mb-4">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              {{ __('User Management') }}
                              <a href="{{ route('admin.user_management.create') }}" class="btn btn-primary">{{ __('New User') }}</a>
                        </div>

                        <div class="card-body">
                              <table class="dataTable table table-striped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Username') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Created At') }}</th>
                                                <th>{{ __('Updated At') }}</th>
                                                <th>{{ __('Action') }}</th>
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
                                                <td>{{ $user->created_at->format('Y-m-d h:ia') }}</td>
                                                <td>{{ $user->updated_at->format('Y-m-d h:ia') }}</td>
                                                <td><button type="button" class="btn btn-danger" onclick="promptDeleteWarning(this)" data-id="{{ $user->id }}">{{ __('Delete') }}</button></td>
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
                              {{ __('Student Management') }}
                              <div>
                                    <a href="{{ route('admin.user_management.student.rest_time') }}" class="btn btn-primary">{{ __('Manage Rest Time') }}</a>
                                    <a href="{{ route('admin.user_management.student.create') }}" class="btn btn-primary">{{ __('New Student') }}</a>
                              </div>
                        </div>

                        <div class="card-body">
                              <table class="dataTable table table-striped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>{{ __('Student Number') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Username') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('Address') }}</th>
                                                <th>{{ __('Created At') }}</th>
                                                <th>{{ __('Updated At') }}</th>
                                                <th>{{ __('Action') }}</th>
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
                                                      <a class="btn btn-primary" href="{{ route('admin.user_management.student.edit', ['id' => $student->id]) }}">{{ __('Edit') }}</a>
                                                      <button type="button" class="btn btn-danger" onclick="promptDeleteStudentWarning(this)" data-id="{{ $student->id }}">{{ __('Delete') }}</button>
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
                                    '{{ route("admin.user_management.delete") }}', {
                                          user_id: $(item).data('id'),
                                    })
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
                                    '{{  route("admin.user_management.student.delete") }}', {
                                          student_id: $(item).data('id'),
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