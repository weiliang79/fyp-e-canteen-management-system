@extends('layouts.student.app_public')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-20">
                <div class="card">
                    <div class="card-header">
                        Profile
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                                <div class="card mb-4">
                                    <div class="card-header">
                                        Edit Profile
                                    </div>

                                    <div class="card-body">

                                        <form method="POST" action="{{ route('student.profile.update_profile') }}">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for=""
                                                       class="col-md-3 col-form-label text-md-end">{{ __('First and Last Name') }}</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center">
                                                            <i class="fa-solid fa-id-card fa-fw"></i>
                                                        </div>

                                                        <input type="text"
                                                               class="form-control @error('first_name') is-invalid @enderror"
                                                               name="first_name"
                                                               value="{{ old('first_name', auth()->guard('student')->user()->first_name) }}">
                                                        <input type="text"
                                                               class="form-control @error('last_name') is-invalid @enderror"
                                                               name="last_name"
                                                               value="{{ old('last_name', auth()->guard('student')->user()->last_name) }}">

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
                                                <label for=""
                                                       class="col-md-3 col-form-label text-md-end">{{ __('Phone') }}</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center">
                                                            <i class="fa-solid fa-phone fa-fw"></i>
                                                        </div>

                                                        <input type="text"
                                                               class="form-control @error('phone') is-invalid @enderror"
                                                               name="phone"
                                                               value="{{ old('phone', auth()->guard('student')->user()->phone) }}"
                                                               placeholder="Phone">

                                                        @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for=""
                                                       class="col-md-3 col-form-label text-md-end">{{ __('Address') }}</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center">
                                                            <i class="fa-solid fa-id-card fa-fw"></i>
                                                        </div>

                                                        <input type="text"
                                                               class="form-control @error('address') is-invalid @enderror"
                                                               name="address"
                                                               value="{{ old('address', auth()->guard('student')->user()->address) }}"
                                                               placeholder="Address">

                                                        @error('address')
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

                                <div class="card mb-4">
                                    <div class="card-header">
                                        Update Email Address
                                    </div>

                                    <div class="card-body">

                                        <form method="POST" action="{{ route('student.profile.update_email') }}"
                                              onkeydown="return event.key != 'Enter';">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="" class="col-md-3 col-form-label text-md-end">Email Address</label>

                                                <div class="col-md-8">
                                                    <div id="email_group" class="input-group">
                                                        <div class="input-group-text justify-content-center"
                                                             style="width: 8%;">
                                                            <i class="fa-solid fa-at fa-fw"></i>
                                                        </div>

                                                        <input type="text"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               name="email" id="email_field" placeholder="Email Address"
                                                               value="{{ old('email', auth()->guard('student')->user()->email) }}">
                                                        <button type="button" class="btn btn-primary"
                                                                onclick="sendVerifyEmail();">Send Verification Code
                                                        </button>

                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="code">
                                                @error('code')
                                                <div class="code_input">
                                                    <div class="row mb-3">
                                                        <label for="" class="col-md-3 col-form-label text-md-end">Verification Code</label>

                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <div class="input-group-text justify-content-center"
                                                                     style="width: 8%;">
                                                                    <i class="fa-solid fa-key fa-fw"></i>
                                                                </div>

                                                                <input type="text"
                                                                       class="form-control @error('code') is-invalid @enderror"
                                                                       name="code" placeholder="Verification Code">

                                                                @error('code')
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
                                                </div>
                                                @enderror
                                            </div>

                                        </form>

                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        Change Password
                                    </div>

                                    <div class="card-body">

                                        <form action="{{ route('student.profile.update_password') }}" method="post">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="" class="col-md-3 col-form-label text-md-end">New Password</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center"
                                                             style="width: 8%;">
                                                            <i class="fa-solid fa-key fa-fw"></i>
                                                        </div>

                                                        <input type="password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               name="password" placeholder="New Password">

                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="" class="col-md-3 col-form-label text-md-end">Confirm Password</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center"
                                                             style="width: 8%;">
                                                            <i class="fa-solid fa-key fa-fw"></i>
                                                        </div>

                                                        <input type="password"
                                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                                               name="password_confirmation"
                                                               placeholder="Confirm Password">

                                                        @error('password_confirmation')
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

                                <div class="card">
                                    <div class="card-header">
                                        Notification
                                    </div>

                                    <div class="card-body">

                                        <form action="{{ route('student.profile.update_notify') }}" method="POST">
                                            @csrf
                                            
                                            <div class="row mb-3">
                                                <label for="" class="col-md-3 col-form-label text-md-end">Email</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center" style="width: 8%;">
                                                            <i class="fa-solid fa-envelope fa-fw"></i>
                                                        </div>

                                                        <div class="form-check form-switch form-switch-md" style="margin: 0.3rem 0 0.3rem 0.5rem;">
                                                            <input type="checkbox" class="form-check-input" role="switch" id="statusSwitch" name="email_notify" {{ auth()->guard('student')->user()->allow_email_notify ? 'checked' : '' }}>
                                                        </div>
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

                            <div class="col-4">

                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5 class="mb-0">Student Number</h5>
                                        <p class="mb-0">{{ auth()->guard('student')->user()->student_number }}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="mb-0">Full Name</h5>
                                        <p class="mb-0">{{ auth()->guard('student')->user()->first_name }} {{ auth()->guard('student')->user()->last_name }}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="mb-0">Username</h5>
                                        <p class="mb-0">{{ auth()->guard('student')->user()->username }}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="mb-0">Email Address</h5>
                                        <p class="mb-0">{{ auth()->guard('student')->user()->email ? auth()->guard('student')->user()->email : 'None' }}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="mb-0">Phone</h5>
                                        <p class="mb-0">{{ auth()->guard('student')->user()->phone ? auth()->guard('student')->user()->phone : 'None' }}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="mb-0">Address</h5>
                                        <p class="mb-0">{{ auth()->guard('student')->user()->address ? auth()->guard('student')->user()->address : 'None' }}</p>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="code_template">
        <div id="code_input">
            <div class="row mb-3">
                <label for="" class="col-md-3 col-form-label text-md-end">Verification Code</label>

                <div class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-text justify-content-center" style="width: 8%;">
                            <i class="fa-solid fa-key fa-fw"></i>
                        </div>

                        <input type="text" class="form-control" name="code" placeholder="Verification Code">
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
        </div>
    </template>

    <script>
        function sendVerifyEmail() {
            event.preventDefault();

            var email = $('#email_field').val();
            if (email === null || email === undefined || email === '') {
                if ($('#email_field').hasClass('is-valid')) {
                    $('#email_field').removeClass('is-valid');
                }
                $('#email_field').addClass('is-invalid');

                if ($('#email_group').children('.valid-feedback').length == 1) {
                    $('#email_group').children('.valid-feedback').remove();
                }
                if ($('#email_group').children('.invalid-feedback').length == 1) {
                    $('#email_group').children('.invalid-feedback').remove();
                }
                $('#email_group').append('<span class="invalid-feedback" role="alert"><strong>The email field is required.</strong></span>');
            } else if (!validateEmail(email)) {
                if ($('#email_field').hasClass('is-valid')) {
                    $('#email_field').removeClass('is-valid');
                }
                $('#email_field').addClass('is-invalid');

                if ($('#email_group').children('.valid-feedback').length == 1) {
                    $('#email_group').children('.valid-feedback').remove();
                }
                if ($('#email_group').children('.invalid-feedback').length == 1) {
                    $('#email_group').children('.invalid-feedback').remove();
                }
                $('#email_group').append('<span class="invalid-feedback" role="alert"><strong>The field input is not an email format.</strong></span>');
            } else {

                axios.post(
                    '{{ route("student.profile.email_verify") }}',
                    {
                        email: email,
                    })
                    .then(function (response) {

                        if (response.data.status === 'success') {
                            if ($('#email_field').hasClass('is-invalid')) {
                                $('#email_field').removeClass('is-invalid');
                            }

                            $('#email_field').addClass('is-valid');

                            if ($('#email_group').children('.valid-feedback').length == 1) {
                                $('#email_group').children('.valid-feedback').remove();
                            }
                            if ($('#email_group').children('.invalid-feedback').length == 1) {
                                $('#email_group').children('.invalid-feedback').remove();
                            }
                            $('#email_group').append('<span class="valid-feedback"><strong>' + response.data.message + '</strong></span>');

                            if ($('#code').children('#code_input').length == 1) {
                                $('#code').children('#code_input').remove();
                            }
                            html = $('#code_template').html();
                            $('#code').append(html);
                        }

                    })
                    .catch(function (error) {

                        if (error.response.status === 422 && error.response.data.message === 'The email has already been taken.') {

                            if ($('#email_field').hasClass('is-valid')) {
                                $('#email_field').removeClass('is-valid');
                            }
                            $('#email_field').addClass('is-invalid');

                            if ($('#email_group').children('.invalid-feedback').length == 1) {
                                $('#email_group').children('.invalid-feedback').remove();
                            }
                            $('#email_group').append('<span class="invalid-feedback" role="alert"><strong>The email has already been taken.</strong></span>');

                        } else {

                            if ($('#email_field').hasClass('is-valid')) {
                                $('#email_field').removeClass('is-valid');
                            }
                            $('#email_field').addClass('is-invalid');

                            if ($('#email_group').children('.invalid-feedback').length == 1) {
                                $('#email_group').children('.invalid-feedback').remove();
                            }
                            $('#email_group').append('<span class="invalid-feedback" role="alert"><strong>We couldn\'t send verification email to the specified email address.</strong></span>');

                        }

                    });

            }
        }

        function validateEmail(email) {
            let emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return emailReg.test(email);
        }
    </script>

@endsection
