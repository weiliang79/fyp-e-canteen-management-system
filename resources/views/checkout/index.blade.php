@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Checkout') }}
                        </div>

                        <div class="card-body">

                              <div class="row">

                                    <div class="col-4 border-end">
                                          <h5>{{ __('Order Details') }}</h5>

                                          <p class="mb-1">{{ 'Student Name: ' . $order->student->first_name . ' ' . $order->student->last_name }}</p>
                                          <p class="mb-1">{{ 'Total Price: ' . config('payment.currency_symbol') . $order->total_price }}</p>
                                          <p class="mb-1">{{ 'Pick-Up Date: ' . $order->pick_up_start->format('Y/m/d h:ia') . ' to ' . $order->pick_up_end->format('Y/m/d h:ia') }}</p>

                                          <table class="dataTable-cart table table-striped" style="width: 100%;">
                                                <thead>
                                                      <tr>
                                                            <th>{{ __('Product') }}</th>
                                                            <th>{{ 'Price(' . config('payment.currency_symbol') . ')' }}</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      @foreach($order->orderDetails as $detail)
                                                      <tr>
                                                            <td>{{ $detail->product->name }}</td>
                                                            <td>{{ $detail->price }}</td>
                                                      </tr>
                                                      @endforeach
                                                </tbody>
                                          </table>
                                    </div>

                                    <div class="col-8">
                                          <h5>{{ __('Payment Method') }}</h5>

                                          <p class="mb-1">{{ __('Please choose a payment method to procced transaction.') }}</p>

                                          @error('payment')
                                          <div class="row my-4">
                                                <div class="col-md-8 offset-md-3 text-danger">
                                                      <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('Please choose a valid payment method.') }}
                                                </div>
                                          </div>
                                          @enderror

                                          <form action="{{ route('student.checkout.process', ['order_id' => $order->id]) }}" method="post">
                                                @csrf

                                                @if(config('payment.2c2p-status'))
                                                <div class="row mb-3">
                                                      <div class="col">
                                                            <div class="form-check">
                                                                  <input type="radio" class="form-check-input" name="payment" id="payment2c2p" value="2c2p">
                                                                  <label for="payment2c2p" class="form-check-label">
                                                                        <img src="{{ asset('storage/defaults/2C2P_Logo/PNG/2C2P_Logo_RGB_Dark_Green.png') }}" alt="2C2P Logo" style="width: 20%;">
                                                                        <p class="mb-1 ms-3">{{ \App\Models\PaymentType::find(\App\Models\PaymentType::PAYMENT_2C2P)->description }}</p>
                                                                  </label>
                                                            </div>
                                                      </div>
                                                </div>
                                                @endif

                                                @if(config('payment.stripe-status'))
                                                <div class="row mb-3">
                                                      <div class="col">
                                                            <div class="form-check">
                                                                  <input type="radio" class="form-check-input" name="payment" id="paymentStripe" value="stripe">
                                                                  <label for="paymentStripe" class="form-check-label">
                                                                        <img src="{{ asset('storage/defaults/Stripe_Logo/Stripe wordmark - blurple (small).png') }}" alt="Stripe Logo" style="width: 20%;">
                                                                        <p class="mb-1 ms-3">{{ \App\Models\PaymentType::find(\App\Models\PaymentType::PAYMENT_STRIPE)->description }}</p>
                                                                  </label>
                                                            </div>
                                                      </div>
                                                </div>
                                                @endif

                                                <div class="row mb-0">
                                                      <div class="col-md-8 offset-md-1">
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
      </div>
</div>

@endsection