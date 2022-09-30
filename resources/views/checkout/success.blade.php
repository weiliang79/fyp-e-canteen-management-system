@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col">
                  <div class="card">
                        <div class="card-header">
                              Checkout - Payment Success
                        </div>

                        <div class="card-body">

                              <div class="row my-4">
                                    <div class="col text-success text-center">
                                          <i class="fa-solid fa-circle-check fa-lg"></i> The Payment was successful.
                                    </div>
                              </div>

                              <div class="row justify-content-center my-4">
                                    <div class="col-md-4">
                                          <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Payment Type</p>
                                                      <p class="mb-1">
                                                            {{ $payment->payment_type_id == \App\Models\PaymentType::PAYMENT_2C2P ? '2C2P' : 'Stripe' }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Payment Processing Method</p>
                                                      <p class="mb-1">
                                                            @if($payment->payment_type_id == \App\Models\PaymentType::PAYMENT_2C2P)
                                                                  {{ $payment->paymentDetail2c2p->channel_code }}
                                                            @elseif($payment->payment_type_id == \App\Models\PaymentType::PAYMENT_STRIPE)
                                                                  {{ Auth::guard('student')->user()->findPaymentMethod($payment->paymentDetailStripe->payment_method_id)->card->brand }}
                                                            @endif
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Email</p>
                                                      <p class="mb-1">
                                                            {{ Auth::guard('student')->user()->email }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Phone</p>
                                                      <p class="mb-1">
                                                            {{ Auth::guard('student')->user()->phone }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="fw-bold mb-1">Amount Paid</p>
                                                      <p class="fw-bold mb-1">
                                                      {{ config('payment.currency_symbol') }}{{ $payment->amount }}
                                                      </p>
                                                </li>

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
                                                            {{ $payment->paymentDetail2c2p->transaction_time->format('Y-m-d h:ia') }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Agent Code</p>
                                                      <p class="mb-1">
                                                            {{ $payment->paymentDetail2c2p->agent_code }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Channel Code</p>
                                                      <p class="mb-1">
                                                            {{ $payment->paymentDetail2c2p->channel_code }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Reference No</p>
                                                      <p class="mb-1">
                                                            {{ $payment->paymentDetail2c2p->reference_no }}
                                                      </p>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                      <p class="mb-1">Transaction Reference</p>
                                                      <p class="mb-1">
                                                            {{ $payment->paymentDetail2c2p->tran_ref }}
                                                      </p>
                                                </li>
                                                @endif
                                          </ul>
                                    </div>
                              </div>

                              <div class="row justify-content-center">
                                    <div class="col-md-auto">
                                          <a class="btn btn-primary" href="{{ route('student.order') }}">Order History</a>
                                          <a class="btn btn-primary" href="{{ route('student.menus') }}">Menu</a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection
