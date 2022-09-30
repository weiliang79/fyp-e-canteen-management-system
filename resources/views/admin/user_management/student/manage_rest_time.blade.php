@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center mb-4">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Rest Time Management
                        </div>

                        <div class="card-body">

                              @if($errors->any())
                              <div class="row my-4">
                                    <div class="col-md-8 offset-md-3 text-danger">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> The field is required to add at least one rest time.
                                    </div>
                              </div>
                              @endif

                              <form action="{{ route('admin.user_management.student.rest_time.update') }}" method="post">
                                    @csrf

                                    <div id="days">
                                          @if($restTimes)
                                          @foreach($restTimes as $restTime)
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
                                                                              <option value="{{ $key }}" {{ $restTime->day_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                              @endforeach
                                                                        </select>
                                                                  </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                  <label for="">Start Time</label>

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
                                                                  <label for="">End Time</label>

                                                                  <div class="input-group">
                                                                        <div class="input-group-text justify-content-center" style="width: 10%;">
                                                                              <i class="fa-solid fa-clock fa-fw"></i>
                                                                        </div>
                                                                        <input class="form-control timepicker" type="text" name="end_time[]" placeholder="End Time" value="{{ $restTime->end_time }}">
                                                                  </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                  <label for="">Description</label>

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
