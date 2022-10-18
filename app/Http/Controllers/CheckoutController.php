<?php

namespace App\Http\Controllers;

use App\Mail\StudentOrderSuccessful;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentDetail2c2p;
use App\Models\PaymentDetailStripe;
use App\Models\PaymentType;
use App\Models\Student;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Mail;
use Stripe\Exception\ApiErrorException;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::guard('student')->user();
        $order = Order::find($request->order_id);

        if ($order->student_id !== $student->id) {
            abort(403);
        }

        return view('checkout.index', compact('order'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment' => 'required',
        ]);

        if ($request->payment == '2c2p') {

            return redirect()->route('student.checkout.2c2p.process', [
                'order_id' => $request->order_id,
            ]);

        } else if ($request->payment == 'stripe') {
            // TODO: for stripe payment
            return redirect()->route('student.checkout.stripe', [
                'order_id' => $request->order_id,
            ]);
        }
    }

    public function process2c2p(Request $request)
    {
        $order = Order::find($request->order_id);

        echo '<center>
        <h3>Please wait while we redirect you to 2C2P secure site.</h3>
        <p>Don\'t refresh until the page is redirected.</p>
        </center>';

        if (config('payment.2c2p-sandbox.status') == true) {
            $url = config('payment.2c2p-sandbox.url') . 'paymentToken';
            $info2c2p = [
                'merchantID' => config('payment.2c2p-sandbox.merchantID'),
                'currencyCode' => config('payment.2c2p-sandbox.currencyCode'),
                'secretCode' => config('payment.2c2p-sandbox.secretCode'),
                'localeCode' => config('payment.2c2p-sandbox.localeCode'),
            ];
        } else {
            $url = config('payment.2c2p.url') . 'paymentToken';
            $info2c2p = [
                'merchantID' => config('payment.2c2p.merchantID'),
                'currencyCode' => config('payment.2c2p.currencyCode'),
                'secretCode' => config('payment.2c2p.secretCode'),
                'localeCode' => config('payment.2c2p.localeCode'),
            ];
        }

        $invoiceCount = PaymentDetail2c2p::whereDate('created_at', Carbon::today())->count() == 0 ? 1 : PaymentDetail2c2p::whereDate('created_at', Carbon::today())->count() + 1;
        $payload = CheckoutController::getTokenRequestPayload($info2c2p, Carbon::now()->format('Ymd') . str_pad($invoiceCount, 4, 0, STR_PAD_LEFT), $order);
        $jwt = JWT::encode($payload, $info2c2p['secretCode'], config('payment.2c2p-algorithm'));
        $requestData = '{"payload": "' . $jwt . '"}';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $url, [
            'body' => $requestData,
            'headers' => [
                'Accept' => 'text/plain',
                'Content-Type' => 'application/*+json',
            ],
        ]);

        $decode = (array) json_decode($response->getBody(), true);

        if (!array_key_exists('payload', $decode)) {
            if ($decode['respCode'] == '9015') {
                //dd('invoice exist');

                while ($decode['respCode'] == '9015') {
                    $invoiceCount++;
                    $payload = CheckoutController::getTokenRequestPayload($info2c2p, Carbon::now()->format('Ymd') . str_pad($invoiceCount, 4, 0, STR_PAD_LEFT), $order);
                    $jwt = JWT::encode($payload, $info2c2p['secretCode'], config('payment.2c2p-algorithm'));
                    $requestData = '{"payload": "' . $jwt . '"}';

                    $response = $client->request('POST', $url, [
                        'body' => $requestData,
                        'headers' => [
                            'Accept' => 'text/plain',
                            'Content-Type' => 'application/*+json',
                        ],
                    ]);

                    $decode = json_decode($response->getBody(), true);

                    if (array_key_exists('payload', $decode)) {
                        break;
                    }
                }
            } else {
                // error
                return redirect()->route('student.checkout.failure', ['order_id' => $order->id, 'payment_type' => '2c2p', 'resp_code' => $decode['respCode']]);
            }
        }

        $decodedPayload = (array) JWT::decode($decode['payload'], new Key($info2c2p['secretCode'], config('payment.2c2p-algorithm')));

        if ($decodedPayload['respCode'] !== '0000') {
            // error
            return redirect()->route('student.checkout.failure', ['order_id' => $order->id, 'payment_type' => '2c2p', 'resp_code' => $decodedPayload['respCode']]);
        }

        $payment2c2p = PaymentDetail2c2p::create([
            'invoice_no' => $payload['invoiceNo'],
            'amount' => $payload['amount'],
            'currency_code' => $payload['currencyCode'],
            'status' => PaymentDetail2c2p::STATUS_PENDING,
        ]);

        $payment = $order->payments()->create([
            'payment_type_id' => PaymentType::PAYMENT_2C2P,
            'payment_detail_2c2p_id' => $payment2c2p->id,
            'amount' => $order->total_price,
            'status' => Payment::STATUS_PENDING,
            'is_sandbox_payment' => config('payment.2c2p-sandbox.status'),
        ]);

        return redirect()->to($decodedPayload['webPaymentUrl']);
    }

    public function receivePaymentInfo(Request $request)
    {

        $request->validate([
            'paymentResponse' => 'required',
        ]);

        echo '<center>
        <h3>Please wait while we receiving your payment result.</h3>
        <p>Don\'t refresh until the page is redirected.</p>
        </center>';

        $decode = (array) json_decode(base64_decode($request->paymentResponse));

        if (config('payment.2c2p-sandbox.status') == true) {
            $url = config('payment.2c2p-sandbox.url') . 'paymentInquiry';
            $info2c2p = [
                'merchantID' => config('payment.2c2p-sandbox.merchantID'),
                'currencyCode' => config('payment.2c2p-sandbox.currencyCode'),
                'secretCode' => config('payment.2c2p-sandbox.secretCode'),
                'localeCode' => config('payment.2c2p-sandbox.localeCode'),
            ];
        } else {
            $url = config('payment.2c2p.url') . 'paymentInquiry';
            $info2c2p = [
                'merchantID' => config('payment.2c2p.merchantID'),
                'currencyCode' => config('payment.2c2p.currencyCode'),
                'secretCode' => config('payment.2c2p.secretCode'),
                'localeCode' => config('payment.2c2p.localeCode'),
            ];
        }

        $payload = CheckoutController::getPaymentInquiryPayload($info2c2p, $decode['invoiceNo']);
        $jwt = JWT::encode($payload, $info2c2p['secretCode'], config('payment.2c2p-algorithm'));
        $requestData = '{"payload": "' . $jwt . '"}';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $url, [
            'body' => $requestData,
            'headers' => [
                'Accept' => 'text/plain',
                'Content-Type' => 'application/*+json',
            ],
        ]);

        echo '<br>' . $response->getBody() . '<br>';

        $inquiryJson = json_decode($response->getBody(), true);
        $inquiryPayload = (array) JWT::decode($inquiryJson['payload'], new Key($info2c2p['secretCode'], config('payment.2c2p-algorithm')));

        foreach ($inquiryPayload as $key => $value) {
            echo $key;
            echo " => ";
            echo $value;
            echo "<br>";
        }

        $detail2c2p = PaymentDetail2c2p::where('invoice_no', $decode['invoiceNo'])->first();

        $detail2c2p->update([
            'transaction_time' => Carbon::createFromFormat('YmdHis', $inquiryPayload['transactionDateTime'])->getTimestamp(),
            'agent_code' => $inquiryPayload['agentCode'],
            'channel_code' => $inquiryPayload['channelCode'],
            'approval_code' => $inquiryPayload['approvalCode'],
            'reference_no' => $inquiryPayload['referenceNo'],
            'tran_ref' => $inquiryPayload['tranRef'],
            'resp_code' => $inquiryPayload['respCode'],
            'status' => $inquiryPayload['respCode'] == '0000' ? PaymentDetail2c2p::STATUS_SUCCESS : PaymentDetail2c2p::STATUS_FAILURE,
        ]);

        $payment = $detail2c2p->payment->update([
            'status' => $inquiryPayload['respCode'] == '0000' ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILURE,
        ]);

        $order = $detail2c2p->payment->order;
        $order->update([
            'status' => $inquiryPayload['respCode'] == '0000' ? Order::PAYMENT_SUCCESS : Order::PAYMENT_FAILURE,
        ]);
        $stripePayments = $order->payments()->where('payment_type_id', PaymentType::PAYMENT_STRIPE)->get();

        if ($stripePayments->count() !== 0) {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));
            foreach ($stripePayments as $stripePayment) {
                $stripePayment->update([
                    'status' => Payment::STATUS_ABORT,
                ]);

                $stripePayment->paymentDetailStripe->update([
                    'status' => PaymentDetailStripe::STATUS_ABORT,
                ]);
                try {
                    $stripe->paymentIntents->cancel($stripePayment->paymentDetailStripe->payment_intent_id, [
                        'cancellation_reason' => 'requested_by_customer',
                    ]);
                } catch (ApiErrorException $e) {
                    abort(502);
                }
            }
        }

        if ($inquiryPayload['respCode'] == '0000') {

            $student = $order->student;

            if ($student->email !== null && $student->email_verified_at !== null && $student->allow_email_notify) {
                Mail::to($student)->send(new StudentOrderSuccessful($order));
            }

            return redirect()->route('student.checkout.success', ['order_id' => $detail2c2p->payment->order->id, 'payment_id' => $detail2c2p->payment->id]);
        } else {
            return redirect()->route('student.checkout.failure', ['order_id' => $detail2c2p->payment->order->id, 'payment_type' => '2c2p', 'resp_code' => $inquiryPayload['respCode']]);
        }
    }

    public function stripeCharge(Request $request)
    {

        $student = Student::find(Auth::guard('student')->user()->id);
        $order = Order::find($request->order_id);
        $payment = $order->payments()->where('payment_type_id', PaymentType::PAYMENT_STRIPE)->orderBy('created_at', 'desc')->first();
        $clientSecret = null;

        if ($payment !== null) {
            if ($payment->status === Payment::STATUS_PENDING || $payment->status === Payment::STATUS_FAILURE) {
                if ($payment->paymentDetailStripe->client_secret !== null) {
                    $clientSecret = $payment->paymentDetailStripe->client_secret;
                } else {
                    abort(500);
                }
            }
        } else {
            $paymentIntent = $student->pay($order->total_price * 100, [
                'setup_future_usage' => 'off_session',
            ]);
            $clientSecret = $paymentIntent->clientSecret();

            $stripeDetail = PaymentDetailStripe::create([
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $clientSecret,
                'status' => PaymentDetailStripe::STATUS_PENDING,
            ]);

            $payment = $order->payments()->create([
                'payment_type_id' => PaymentType::PAYMENT_STRIPE,
                'payment_detail_stripe_id' => $stripeDetail->id,
                'amount' => $order->total_price,
                'status' => Payment::STATUS_PENDING,
                'is_sandbox_payment' => config('payment.stripe-sandbox'),
            ]);
        }

        return view('checkout.stripe.payment', [
            'clientSecret' => $clientSecret,
            'order' => $order,
        ]);
    }

    public function stripeProcess(Request $request)
    {

        $student = Student::find(Auth::guard('student')->user()->id);
        $order = Order::find($request->order_id);

        $student->createOrGetStripeCustomer();
        $student->addPaymentMethod($request->payment_method);
        $student->updateDefaultPaymentMethod($request->payment_method);

        $order->update([
            'status' => Order::PAYMENT_SUCCESS,
        ]);

        $payment = $order->payments()->where('payment_type_id', PaymentType::PAYMENT_STRIPE)->orderBy('created_at', 'DESC')->first();
        $payment->update([
            'status' => Payment::STATUS_SUCCESS,
        ]);

        $payment->paymentDetailStripe->update([
            'payment_method_id' => $request->payment_method,
            'status' => PaymentDetailStripe::STATUS_SUCCESS,
        ]);

        if ($student->email !== null && $student->email_verified_at !== null && $student->allow_email_notify) {
            Mail::to($student)->send(new StudentOrderSuccessful($order));
        }

        return redirect()->route('student.checkout.success', ['order_id' => $order->id, 'payment_id' => $payment->id]);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'payment_id' => 'required',
        ]);
        $order = Order::find($request->order_id);
        $payment = Payment::find($request->payment_id);
        return view('checkout.success', compact('order', 'payment'));
    }

    public function paymentFailure(Request $request)
    {
        $paymentType = $request->payment_type;
        $order = Order::find($request->order_id);

        if ($paymentType == '2c2p') {
            $respCode = $request->resp_code;
            return view('checkout.failure', compact('order', 'paymentType', 'respCode'));
        } else {
            // for stripe transaction error
            dd('stripe error');
        }
    }

    function getTokenRequestPayload(array $info2c2p, string $invoiceNo, Order $order)
    {
        return [
            'merchantID' => $info2c2p['merchantID'],
            'invoiceNo' => $invoiceNo,
            'description' => 'Order id: ' . $order->id,
            'amount' => $order->total_price,
            'currencyCode' => $info2c2p['currencyCode'],
            'paymentChannel' => [],
            'frontendReturnUrl' => route('student.checkout.receive_payment_info', ['order_id' => $order->id]),
            'locale' => $info2c2p['localeCode'],
        ];
    }

    function getPaymentInquiryPayload(array $info2c2p, string $invoiceNo)
    {
        return [
            'merchantID' => $info2c2p['merchantID'],
            'invoiceNo' => $invoiceNo,
            'locale' => $info2c2p['localeCode'],
        ];
    }
}
