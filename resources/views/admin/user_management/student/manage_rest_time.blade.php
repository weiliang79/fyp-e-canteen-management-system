@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center mb-4">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Rest Time Management') }}
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('The form is has some error, please refill and submit again.') }}
                                    </div>
                              </div>
                              @endif

                              <form action="{{ route('admin.user_management.student.rest_time.update') }}" method="post">
                                    @csrf

                                    <div id="days">
                                          @php
                                          $old_restTimeId = session()->getOldInput('rest_time_id');
                                          $old_dayId = session()->getOldInput('day_id');
                                          $old_startTime = session()->getOldInput('start_time');
                                          $old_end_time = session()->getOldInput('end_time');
                                          $old_description = session()->getOldInput('description');
                                          @endphp
                                          @if($restTimes && $old_dayId === null)
                                          @foreach($restTimes as $restTime)
                                          <div class="card mb-4 day_group">
                                                <div class="card-body">
                                                      <input type="hidden" name="rest_time_id[]" value="{{ $restTime->id }}">
                                                      <div class="row mb-3 justify-content-center">
                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('Day') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-calendar-days fa-fw"></i>
                                                                        </div>

                                                                        <select class="form-control" name="day_id[]" id="">
                                                                              @foreach(\App\Models\RestTime::DAYS as $key => $value)
                                                                              <option value="{{ $key }}" {{ $restTime->day_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                              @endforeach
                                                                        </select>
                                                                  </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('Start Time') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-clock fa-fw"></i>
                                                                        </div>
                                                                        <input class="form-control timepicker" type="text" name="start_time[]" placeholder="Start Time" value="{{ $restTime->start_time }}">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="row mb-3 justify-content-center">
                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('End Time') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-clock fa-fw"></i>
                                                                        </div>
                                                                        <input class="form-control timepicker" type="text" name="end_time[]" placeholder="End Time" value="{{ $restTime->end_time }}">
                                                                  </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('Description') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-quote-right"></i>
                                                                        </div>

                                                                        <input class="form-control" type="text" name="description[]" placeholder="Description" value="{{ $restTime->description }}">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="row mb-0">
                                                            <div class="col-md-8 offset-md-10">
                                                                  <button class="btn btn-danger" type="button" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                          @endforeach
                                          @endif

                                          @if($old_dayId)
                                          @foreach($old_dayId as $key => $value)
                                          <div class="card mb-4 day_group">
                                                <div class="card-body">
                                                      @if($old_restTimeId !== null)
                                                      @if(array_key_exists($key, $old_restTimeId))
                                                      <input type="hidden" name="rest_time_id[]" value="{{ $old_restTimeId[$key]  }}">
                                                      @endif
                                                      @endif
                                                      <div class="row mb-3 justify-content-center">
                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('Day') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-calendar-days fa-fw"></i>
                                                                        </div>

                                                                        <select class="form-control" name="day_id[]" id="">
                                                                              @foreach(\App\Models\RestTime::DAYS as $key1 => $value1)
                                                                              <option value="{{ $key1 }}" {{ $old_dayId[$key] == $key1 ? 'selected' : '' }}>{{ $value1 }}</option>
                                                                              @endforeach
                                                                        </select>
                                                                  </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('Start Time') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-clock fa-fw"></i>
                                                                        </div>
                                                                        <input class="form-control timepicker @error('start_time.' . $key) is-invalid @enderror" type="text" name="start_time[]" placeholder="Start Time" value="{{ $old_startTime[$key] }}">
                                                                        @error('start_time.' . $key)
                                                                        <span class="invalid-feedback" role="alert">
                                                                              <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="row mb-3 justify-content-center">
                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('End Time') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-clock fa-fw"></i>
                                                                        </div>
                                                                        <input class="form-control timepicker @error('end_time.' . $key) is-invalid @enderror" type="text" name="end_time[]" placeholder="End Time" value="{{ $old_end_time[$key] }}">
                                                                        @error('end_time.' . $key)
                                                                        <span class="invalid-feedback" role="alert">
                                                                              <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                  </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                  <label for="">{{ __('Description') }}</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-quote-right"></i>
                                                                        </div>

                                                                        <input class="form-control" type="text" name="description[]" placeholder="Description" value="{{ $old_description[$key] }}">
                                                                  </div>
                                                            </div>
                                                      </div>

                                                      <div class="row mb-0">
                                                            <div class="col-md-8 offset-md-10">
                                                                  <button class="btn btn-danger" type="button" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>
                                                            </div>
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

                                    <div class="row mb-0">
                                          <div class="col-md-8 offset-md-2">
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
      <div class="card mb-4 day_group">
            <div class="card-body">
                  <div class="row mb-3 justify-content-center">
                        <div class="col-md-4">
                              <label for="">Day</label>

                              <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 10%;">
                                          <i class="fa-solid fa-calendar-days fa-fw"></i>
                                    </div>

                                    <select class="form-control" name="day_id[]" id="">
                                          @foreach(\App\Models\RestTime::DAYS as $key => $value)
                                          <option value="{{ $key }}">{{ $value }}</option>
                                          @endforeach
                                    </select>
                              </div>
                        </div>

                        <div class="from=group col-md-4">
                              <label for="">Start Time</label>

                              <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 10%;">
                                          <i class="fa-solid fa-clock fa-fw"></i>
                                    </div>
                                    <input class="form-control timepicker" type="text" name="start_time[]" placeholder="Start Time">
                              </div>
                        </div>
                  </div>

                  <div class="row mb-3 justify-content-center">
                        <div class="col-md-4">
                              <label for="">End Time</label>

                              <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 10%;">
                                          <i class="fa-solid fa-clock fa-fw"></i>
                                    </div>
                                    <input class="form-control timepicker" type="text" name="end_time[]" placeholder="End Time">
                              </div>
                        </div>

                        <div class="col-md-4">
                              <label for="">Description</label>

                              <div class="input-group">
                                    <div class="input-group-text justify-content-center" style="width: 10%;">
                                          <i class="fa-solid fa-quote-right"></i>
                                    </div>

                                    <input class="form-control" type="text" name="description[]" placeholder="Description">
                              </div>
                        </div>
                  </div>

                  <div class="row mb-0">
                        <div class="col-md-8 offset-md-10">
                              <button class="btn btn-danger" type="button" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>
                        </div>
                  </div>
            </div>
      </div>
</template>

<script>
      function addDays() {
            html = $('#day_templates').html();
            item = $('#days').append(html);

            flatpickr('.timepicker', {
                  enableTime: true,
                  noCalendar: true,
                  dateFormat: 'h:i K',
            });
      }

      function delDays(item) {
            $(item).parents('.day_group').remove();
      }
</script>

@endsection