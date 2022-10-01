@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Order
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Student Number</th>
                                                <th>Student Name</th>
                                                <th>Pick Up Time</th>
                                                <th>Amount({{ config('payment.currency_symbol') }})</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($orders as $order)
                                          <tr>
                                                <td>@if($order->is_sandbox_order) <i class="fa-solid fa-flask fa-fw"></i> @endif{{ $order->student->student_number }}</td>
                                                <td>{{ $order->student->first_name }} {{ $order->student->last_name }}</td>
                                                <td>{{ $order->pick_up_start->format('Y/m/d h:ia') }} to {{ $order->pick_up_end->format('Y/m/d h:ia') }}</td>
                                                <td>{{ $order->total_price }}</td>
                                                <td>{{ $order->getStatusString() }}</td>
                                                <td>{{ $order->created_at->format('Y/m/d h:ia') }}</td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('admin.order.details', ['order_id' => $order->id]) }}">Details</a>
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

@endsection
