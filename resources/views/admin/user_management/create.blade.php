@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              User Management
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> The form has some error, please refill and submit again.
                                    </div>
                              </div>
                              @endif

                              <form method="POST" action="{{ route('admin.user_management.save') }}">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('First and Last Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-id-card fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                                                      <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">

                                                      @error('first_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror

                                                      @error('last_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Username') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-id-card fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username">

                                                      @error('username')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Email') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-at fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email">

                                                      @error('email')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                                <small class="form-text text-muted">*The email field can be empty.</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Password') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-key fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="{{ old('password') }}" placeholder="Password">
                                                      <button type="button" class="btn btn-primary" onclick="generatePassword()">Generate Password</button>

                                                      @error('password')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Role') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-user-tag fa-fw"></i>
                                                      </div>

                                                      <select class="form-select @error('role') is-invalid @enderror" name="role">
                                                            <option value="0">Select a role</option>
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->id }}" {{ $role->id == old('role') ? 'selected' : '' }}>{{ $role->name }}</option>
                                                            @endforeach
                                                      </select>

                                                      @error('role')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-0">
                                          <div class="col-md-8 offset-md-3">
                                                <button type="submit" class="btn btn-primary">
                                                      {{ __('Submit') }}
                                                </button>
                                          </div>
                                    </div>

                              </form>

                        </div>
                  </div>
            </div>
      </div>
</div>

<script>
      function generatePassword() {
            var randomString = Math.random().toString(36).slice(-8);
            document.getElementById("password").value = randomString;
      }
</script>

@endsection