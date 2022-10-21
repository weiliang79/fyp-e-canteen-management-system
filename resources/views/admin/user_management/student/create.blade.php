@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Student Management') }}
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('The form has some error, please refill and submit again.') }}
                                    </div>
                              </div>
                              @endif

                              <form method="POST" action="{{ route('admin.user_management.student.save') }}">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Student Number') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-id-card fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('student_number') is-invalid @enderror" name="student_number" value="{{ old('student_number') }}" placeholder="Student Number">

                                                      @error('student_number')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

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
                                                <small class="form-text text-muted">{{ __('*The email field can be empty.') }}</small>
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
                                                      <button type="button" class="btn btn-primary" onclick="generatePassword()">{{ __('Generate Password') }}</button>

                                                      @error('password')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Phone') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-phone fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone">

                                                      @error('phone')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                                <small class="form-text text-muted">{{ __('*The phone field can be empty.') }}</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Address') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text justify-content-center" style="width: 6%;">
                                                            <i class="fa-solid fa-id-card fa-fw"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="Address">

                                                      @error('address')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                                <small class="form-text text-muted">{{ __('*The address field can be empty.') }}</small>
                                          </div>
                                    </div>

                                    <div class="row mb-3 justify-content-center">
                                          <div class="col-md-10">
                                                <div class="card">
                                                      <div class="card-header">
                                                            {{ __('Student Rest Time') }}
                                                      </div>

                                                      <div class="card-body">

                                                            <div id="days">
                                                                  @if(session()->getOldInput('rest_id'))
                                                                  @foreach(session()->getOldInput('rest_id') as $key => $value)
                                                                  <div class="row mb-3 day-group">
                                                                        <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Rest Time') }}</label>

                                                                        <div class="col-md-8">
                                                                              <div class="input-group">
                                                                                    <div class="input-group-text justify-content-center" style="width: 8%;">
                                                                                          <i class="fa-solid fa-calendar-days fa-fw"></i>
                                                                                    </div>

                                                                                    <select class="form-control @if($errors->has('rest_id.'.$key)) is-invalid @endif" name="rest_id[{{ $key }}]" id="">
                                                                                          <option value="0">{{ __('Select a rest time') }}</option>
                                                                                          @foreach($restTimes as $restTime)
                                                                                          <option value="{{ $restTime->id }}" {{ $restTime->id == $value ? 'selected' : '' }}>{{ $restTime->start_time . ' - ' . $restTime->end_time . $restTime->description ? ' - [' . $restTime->description . ' ]' : '' }}</option>
                                                                                          @endforeach
                                                                                    </select>

                                                                                    <button type="button" class="btn btn-danger" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>

                                                                                    @if($errors->has('rest_id.'.$key))
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                          <strong>{{ $errors->first('rest_id.'.$key) }}</strong>
                                                                                    </span>
                                                                                    @endif
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  @endforeach
                                                                  @endif
                                                            </div>

                                                            <div class="row mb-0">
                                                                  <div class="col-md-8 offset-md-10">
                                                                        <button class="btn btn-primary" type="button" onclick="addDays(this);"><i class="fa-solid fa-plus"></i></button>
                                                                  </div>
                                                            </div>
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
      </div>
</div>

<template id="day_templates">
      <div class="row mb-3 day-group">
            <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Rest Time') }}</label>

            <div class="col-md-8">
                  <div class="input-group">
                        <div class="input-group-text justify-content-center" style="width: 8%;">
                              <i class="fa-solid fa-calendar-days fa-fw"></i>
                        </div>

                        <select class="form-control" name="rest_id[]" id="">
                              <option value="0">{{ __('Select a rest time') }}</option>
                              @foreach($restTimes as $restTime)
                              <option value="{{ $restTime->id }}">{{ $restTime->start_time . ' - ' . $restTime->end_time . $restTime->description ? ' - [' . $restTime->description . ' ]' : '' }}</option>
                              @endforeach
                        </select>

                        <button type="button" class="btn btn-danger" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>
                  </div>
            </div>
      </div>
</template>

<script>
      function generatePassword() {
            var randomString = Math.random().toString(36).slice(-8);
            document.getElementById("password").value = randomString;
      }

      function addDays() {
            html = $('#day_templates').html();
            item = $('#days').append(html);
      }

      function delDays(item) {
            $(item).parents('.day-group').remove();
      }
</script>

@endsection