@component('mail::message')
# Order Confirmation

Dear {{ $order->student->first_name }} {{ $order->student->last_name }},
Thanks for your order. We hope you enjoyed the meal during your rest time.

What you ordered: 
@component('mail::table')
|Product | Option | Price |
| :--------- | :-------- | :--------- |
@foreach ($order->orderDetails as $detail)
|{{ $detail->product->name }} | @foreach ($detail->product_options as $option) @foreach ($option as $key => $value) {{ $detail->product->productOptions()->find($key)->name }} : {{ $detail->product->productOptions()->find($key)->optionDetails()->find($value)->name }} <br> @endforeach @endforeach | {{ config('payment.currency_symbol') . $detail->price }} |
@endforeach
@endcomponent

*Reminder to take your meal on <strong>{{ $order->pick_up_start->format('Y-m-d h:ia') }}</strong> until <strong>{{ $order->pick_up_end->format('Y-m-d h:ia') }}</strong>.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
