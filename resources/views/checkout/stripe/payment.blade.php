@extends('layouts.student.app_public')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Stripe Payment
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-4 border-end">
                                <h5>Order Details</h5>

                                <p class="mb-1">Student
                                    Name: {{ $order->student->first_name }} {{ $order->student->last_name }}</p>
                                <p class="mb-1">Total
                                    Price: {{ config('payment.currency_symbol') }}{{ $order->total_price }}</p>
                                <p class="mb-1">Pick-Up Date: {{ $order->pick_up_start->format('Y/m/d h:ia') }}
                                    to {{ $order->pick_up_end->format('Y/m/d h:ia') }}</p>

                                <table class="dataTable-cart table table-striped" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price({{ config('payment.currency_symbol') }})</th>
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

                                @if($errors->any())
                                    <div class="row my-2">
                                        <div class="col text-danger text-center">
                                            <i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ $errors->all()[0] }}
                                        </div>
                                    </div>
                                @endif

                                <img
                                    src="{{ asset('storage/defaults/Stripe_Logo/Stripe wordmark - blurple (small).png') }}"
                                    alt="Stripe Logo" style="width: 30%;">

                                <p class="mb-4 ms-4">stripe_description</p>

                                <form id="payment-form" action="{{ route('student.checkout.stripe.process', ['order_id' => $order->id]) }}" method="POST">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Card Holder Name') }}</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-text justify-content-center">
                                                    <i class="fa-solid fa-store fa-fw"></i>
                                                </div>

                                                <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Card Holder Name">

                                                <span class="invalid-feedback" role="alert">
                                                    <strong>The card holder name field is required.</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <label for="" class="col-md-2 col-form-label text-md-end">{{ __('Card Info') }}</label>

                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div id="card-element"></div>

                                                    <div id="card-errors" class="text-danger mt-3" role="alert" hidden>
                                                        <i class="fa-solid fa-circle-exclamation fa-lg"></i> <span id="card-errors-text"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div id="payment-element" class="col">

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
                <small class="d-flex justify-content-center">
                    Powered by Stripe, Inc and Stripe JS.
                </small>
            </div>
        </div>
    </div>

    <script>

        const clientSecret = "{{ $clientSecret }}";
        let stripe, elements, paymentElement;

        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        $(document).ready(async () => {

            stripe = await loadStripe('{{ config("cashier.key") }}');
            elements = stripe.elements({
                clientSecret: clientSecret,
            });

            document.querySelector('#payment-form').addEventListener('submit', handleSubmit);

            paymentElement = elements.create('payment', {
                style: style,
            })
            paymentElement.mount('#card-element');

            paymentElement.addEventListener('change', function (event) {
                let cardError = document.getElementById('card-errors');
                let cardErrorText = document.getElementById('card-errors-text');
                if(event.error){
                    cardError.hidden = false;
                    cardErrorText.textContent = event.error.message;
                } else {
                    cardError.hidden = true;
                    cardErrorText.textContent = '';
                }
            });

        });

        async function handleSubmit(e) {
            e.preventDefault();

            let cardholderName = document.getElementById('cardholder_name');

            if(cardholderName.value === null || cardholderName.value === NaN || cardholderName.value === ''){
                cardholderName.classList.add('is-invalid');
                return ;
            } else {
                cardholderName.classList.remove('is-invalid');
            }

            const { paymentIntent, error } = await stripe.confirmPayment({
                elements: elements,
                confirmParams: {
                    payment_method_data: {
                        billing_details: {
                            name: cardholderName.value,
                        },
                    },
                },
                redirect: 'if_required',
            });

            if(error){
                let cardError = document.getElementById('card-errors');
                let cardErrorText = document.getElementById('card-errors-text');
                cardError.hidden = false;
                cardErrorText.textContent = error.message;
            } else {
                let cardError = document.getElementById('card-errors');
                let cardErrorText = document.getElementById('card-errors-text');
                cardError.hidden = true;
                cardErrorText.textContent = '';
                console.log(paymentIntent);

                let form = document.getElementById('payment-form');
                let paymentMethodInput = document.createElement('input');
                paymentMethodInput.setAttribute('type', 'hidden');
                paymentMethodInput.setAttribute('name', 'payment_method');
                paymentMethodInput.setAttribute('value', paymentIntent.payment_method);
                form.appendChild(paymentMethodInput);
                form.submit();
            }
        }

    </script>

@endsection
