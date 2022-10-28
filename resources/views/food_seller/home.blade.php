@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-8">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Home') }}
                        </div>

                        <div class="card-body">

                              <div class="row" style="height: 5rem;">
                                    <div class="col">
                                          <div class="card bg-primary h-100">
                                                <div class="d-flex justify-content-between h-100 px-3">
                                                      <div class="align-self-center">
                                                            <h6 class="mb-0 text-white">{{ __('Order to Pick Up Today: ') }}</h6>
                                                            <h5 class="mb-0 text-white">{{ $orderCount . '/' . $allOrderCount }}</h5>
                                                      </div>
                                                      <div class="align-self-center">
                                                            <i class="fa-solid fa-utensils fa-2xl text-white"></i>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col">
                                          <div class="card bg-success h-100">
                                                <div class="d-flex justify-content-between h-100 px-3">
                                                      <div class="align-self-center">
                                                            <h6 class="mb-0 text-white">{{ __('Sales in This Month: ') }}</h6>
                                                            <h5 class="mb-0 text-white">{{ config('payment.currency_symbol') . $sales }}</h5>
                                                      </div>
                                                      <div class="align-self-center">
                                                            <i class="fa-solid fa-money-bills fa-2xl text-white"></i>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection