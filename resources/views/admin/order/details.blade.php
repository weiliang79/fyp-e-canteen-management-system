@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Order Details
                        </div>

                        <div class="card-body">

                              <div class="row mb-4">
                                    <div class="col-6">
                                          <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Student Number</p>
                                                      <p class="mb-0">@if($order->student->is_a_sandbox_student) <i class="fa-solid fa-flask fa-fw"></i> @endif{{ $order->student->student_number }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Student Name</p>
                                                      <p class="mb-0">{{ $order->student->first_name }} {{ $order->student->last_name }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Student Username</p>
                                                      <p class="mb-0">{{ $order->student->username }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Phone</p>
                                                      <p class="mb-0">{{ $order->student->phone }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Address</p>
                                                      <p class="mb-0">{{ $order->student->address }}</p>
                                                </li>
                                          </ul>
                                    </div>

                                    <div class="col-6">
                                          <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Order ID</p>
                                                      <p class="mb-0">@if($order->is_sandbox_order) <i class="fa-solid fa-flask fa-fw"></i> @endif{{ $order->id }}</p>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Pick Up Time</p>
                                                      <p class="mb-0">{{ $order->pick_up_start->format('Y-m-d h:ia') }} to {{ $order->pick_up_end->format('Y-m-d h:ia') }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Amount</p>
                                                      <p class="mb-0">{{ $order->total_price }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Status</p>
                                                      <p class="mb-0">{{ $order->getStatusString() }}</p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-0">Created At</p>
                                                      <p class="mb-0">{{ $order->created_at->format('Y-m-d h:ia') }}</p>
                                                </li>
                                          </ul>
                                    </div>
                              </div>

                              <div class="row mb-4">
                                    <div class="col">
                                          <div class="card">
                                                <div class="card-header">
                                                      Order List
                                                </div>

                                                <div class="card-body">

                                                      <table class="dataTable table table-stripped" style="width: 100%;">
                                                            <thead>
                                                                  <tr>
                                                                        <th>Store Name</th>
                                                                        <th>Product</th>
                                                                        <th>Option</th>
                                                                        <th>Notes</th>
                                                                        <th>Price({{ config('payment.currency_symbol') }})</th>
                                                                        <th>Action</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  @foreach($order->orderDetails as $detail)
                                                                  <tr>
                                                                        <td>{{ $detail->product->store->name }}</td>
                                                                        <td>{{ $detail->product->name }}</td>
                                                                        <td>
                                                                              @foreach($detail->product_options as $option)
                                                                              @foreach($option as $key => $value)
                                                                              {{ App\Models\ProductOption::find($key)->name }}: {{ App\Models\OptionDetail::find($value)->name }}
                                                                              <br>
                                                                              @endforeach
                                                                              @endforeach
                                                                        </td>
                                                                        <td>{{ $detail->notes ?: 'None' }}</td>
                                                                        <td>{{ $detail->price }}</td>
                                                                        <td>
                                                                            <a class="btn btn-primary" href="{{ route('admin.menus.list.details', ['product_id' => $detail->product->id]) }}">Product Detail</a>
                                                                        </td>
                                                                  </tr>
                                                                  @endforeach
                                                            </tbody>
                                                      </table>

                                                </div>
                                          </div>
                                    </div>
                              </div>

                              @foreach($order->payments()->orderBy('created_at', 'desc')->get() as $payment)
                              <div class="row mb-4">
                                    <div class="col">
                                          <div class="card">
                                                <div class="card-header">
                                                      Payment # {{ $payment->created_at->format('Y-m-d h:i A') }}
                                                </div>

                                                <div class="card-body">
                                                      <div class="row">

                                                            <div class="col-6">
                                                                  <ul class="list-group">
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Payment Type</p>
                                                                              <p class="mb-1">{{ $payment->payment_type_id == \App\Models\PaymentType::PAYMENT_2C2P ? '2C2P' : 'Stripe' }}</p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="fw-bold mb-1">Amount</p>
                                                                              <p class="fw-bold mb-1">{{ config('payment.currency_symbol') }}{{ $payment->amount }}</p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Status</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->getStatusString() }}
                                                                              </p>
                                                                        </li>
                                                                  </ul>
                                                            </div>

                                                            <div class="col-6">
                                                                  <ul class="list-group">
                                                                        @if($payment->payment_type_id == \App\Models\PaymentType::PAYMENT_2C2P)
                                                                        <li class="list-group-item d-flex justify-content-between">

                                                                              <p class="mb-1">Invoice No</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->paymentDetail2c2p->invoice_no }}
                                                                              </p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Transaction Time</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->paymentDetail2c2p->transaction_time->format('Y-m-d H:i A') }}
                                                                              </p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Agent Code</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->paymentDetail2c2p->agent_code ?: 'None' }}
                                                                              </p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Channel Code</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->paymentDetail2c2p->channel_code ?: 'None' }}
                                                                              </p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Reference No</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->paymentDetail2c2p->reference_no ?: 'None' }}
                                                                              </p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Transaction Reference</p>
                                                                              <p class="mb-1">
                                                                                    {{ $payment->paymentDetail2c2p->tran_ref ?: 'None' }}
                                                                              </p>
                                                                        </li>
                                                                        @else

                                                                        @if($payment->status === \App\Models\Payment::STATUS_SUCCESS)
                                                                        @php $paymentMethod = $order->student->findPaymentMethod($payment->paymentDetailStripe->payment_method_id) @endphp

                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Payment
                                                                                    Processing Method</p>
                                                                              <p class="mb-1">{{ $paymentMethod->type }} - {{ $paymentMethod->card->brand }}</p>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                              <p class="mb-1">Transaction Time</p>
                                                                              <p class="mb-1">{{ \Carbon\Carbon::createFromTimestamp($paymentMethod->created)->format('Y-m-d H:i A') }}</p>
                                                                        </li>
                                                                        @endif

                                                                        @endif
                                                                  </ul>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              @endforeach

                              <div class="row mb-0">
                                    <div class="col-md-8 offset-md-3">
                                          <a class="btn btn-primary" href="{{ route('admin.order') }}">Back to Order List</a>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection
