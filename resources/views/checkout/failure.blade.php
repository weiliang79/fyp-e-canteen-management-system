@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Checkout - Payment Failure') }}
                        </div>

                        <div class="card-body">

                              <div class="row my-4">
                                    <div class="col text-danger text-center">
                                          <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ __('The Payment has occurred error during transaction.') }}
                                    </div>
                              </div>

                              <div class="row my-4">
                                    <div class="col text-center">
                                          <p class="mb-1">{{ __('Please contact system administrator if the error reappears multiple times.') }}</p>
                                          <p class="mb-1">{{ 'Order ID: ' . $order->id }}</p>
                                          @if($paymentType === '2c2p')
                                          <p class="mb-1">{{ '2C2P Response Code: ' . $respCode }}</p>
                                          @endif
                                    </div>
                              </div>

                              <div class="row justify-content-center">
                                    <div class="col-md-auto">
                                          <a class="btn btn-primary" href="{{ route('student.order') }}">{{ __('Order History') }}</a>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection