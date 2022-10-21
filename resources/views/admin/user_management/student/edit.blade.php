@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    {{ __('Student Management - Edit Student') }}
                </div>

                <div class="card-body">

                    @if($errors->any())
                    <div class="row my-4">
                        <div class="col-md-8 offset-md-3 text-danger">
                            <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('The form has some error, please refill and submit again.') }}
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">

                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Student Number') }}</p>
                                    <p class="mb-0">{{ $student->student_number }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Student Name') }}</p>
                                    <p class="mb-0">{{ $student->first_name . ' ' . $student->last_name }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Username') }}</p>
                                    <p class="mb-0">{{ $student->username }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Email') }}</p>
                                    <p class="mb-0">{{ $student->email ?: 'None' }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Phone') }}</p>
                                    <p class="mb-0">{{ $student->phone }}</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <p class="mb-0">{{ __('Address') }}</p>
                                    <p class="mb-0">{{ $student->address }}</p>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <form action="{{ route('admin.user_management.student.update', ['id' => $student->id]) }}" method="POST">
                        @csrf

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Student Rest Time') }}
                                    </div>

                                    <div class="card-body">

                                        <div id="days">
                                            @if($student->restTimes && session()->getOldInput('rest_id') === null)
                                            @foreach($student->restTimes as $rest)
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
                                                            <option value="{{ $restTime->id }}" {{ $restTime->id == $rest->id ? 'selected' : '' }}>{{ $restTime->start_time . ' - ' . $restTime->end_time . $restTime->description ? ' - [' . $restTime->description . ' ]' : '' }}</option>
                                                            @endforeach
                                                        </select>

                                                        <button type="button" class="btn btn-danger" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>

                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif

                                            @if(session()->getOldInput('rest_id') !== null)
                                            @php $old = session()->getOldInput('rest_id') @endphp
                                            @for($i = 0; $i < count($old); $i++) <div class="row mb-3 day-group">
                                                <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Rest Time') }}</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text justify-content-center" style="width: 8%;">
                                                            <i class="fa-solid fa-calendar-days fa-fw"></i>
                                                        </div>

                                                        <select class="form-control @error('rest_id.' . $i) is-invalid @enderror" name="rest_id[{{ $i }}]" id="">
                                                            <option value="0">{{ __('Select a rest time') }}</option>
                                                            @foreach($restTimes as $restTime)
                                                            <option value="{{ $restTime->id }}" {{ $restTime->id == $old[$i] ? 'selected' : '' }}>{{ $restTime->start_time . ' - ' . $restTime->end_time . $restTime->description ? ' - [' . $restTime->description . ' ]' : '' }}</option>
                                                            @endforeach
                                                        </select>

                                                        <button type="button" class="btn btn-danger" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>

                                                        @error('rest_id.' . $i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                        </div>
                                        @endfor
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
                    <option value="0">Select a rest time</option>
                    @foreach($restTimes as $restTime)
                    <option value="{{ $restTime->id }}">{{ $restTime->start_time }} - {{ $restTime->end_time }}{{ $restTime->description ? ' - [' . $restTime->description . ' ]' : '' }}</option>
                    @endforeach
                </select>

                <button type="button" class="btn btn-danger" onclick="delDays(this);"><i class="fa-solid fa-minus"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
    function addDays() {
        html = $('#day_templates').html();
        item = $('#days').append(html);
    }

    function delDays(item) {
        $(item).parents('.day-group').remove();
    }
</script>

@endsection