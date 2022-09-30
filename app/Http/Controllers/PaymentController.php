<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Session;

class PaymentController extends Controller
{

    public function index()
    {
        return view('admin.payment.general.index');
    }

    public function saveGeneral(Request $request)
    {

        $request->validate([
            'currency_symbol' => 'required',
        ]);

        DotenvEditor::setKeys([
            'CURRENCY_SYMBOL' => $request->currency_symbol,
            'PAYMENT_MAINTENANCE' => $request->maintenance ? 'true' : 'false',
            '2C2P_ENABLE' => $request->status_2c2p ? 'true' : 'false',
            'STRIPE_ENABLE' => $request->stripe_status ? 'true' : 'false',
        ])->save();

        /*config([
            'payment.currency_symbol' => $request->currency_symbol,
            'payment.maintenance_mode' => $request->maintenance_mode == 'on' ? true : false,
        ]);*/

        //dd($request);

        return redirect()->route('admin.payment.general')->with('swal-success', 'Payment Configuration has updated.');
    }

    public function index2c2p()
    {

        if (config('payment.2c2p-status') == false) {
            return redirect()->route('admin.payment.general')->with('swal-warning', 'Please enable 2C2P payment at General page first.');
        }

        if (config('payment.2c2p-sandbox.status') == true) {
            $url = config('payment.2c2p-sandbox.url') . 'Initialization';
        } else {
            $url = config('payment.2c2p.url') . 'Initialization';
        }

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $url, [
            'headers' => [
                'Accept' => 'text/plain',
                'Content-Type' => 'application/*+json',
            ]
        ]);

        $decode = json_decode($response->getBody());

        if($decode->respCode != 0000){
            Session::flash('swal-warning', 'Unable to receive Locale info from 2C2P.');
            return view('admin.payment.2c2p.index');
        }

        $locale = $decode->initialization->locale;

        return view('admin.payment.2c2p.index', compact('locale'));
    }

    public function save2c2p(Request $request)
    {

        if(!config('payment.maintenance_mode') && $request->sandbox){
            return redirect()->back()->with('swal-warning', 'Please enable maintenance mode before enabling the sandbox mode.');
        }

        $request->validate([
            'merchant_id' => Rule::requiredIf(!config('payment.2c2p-sandbox.status') && $request->sandbox != 'on'),
            'currency_code' => Rule::requiredIf(!config('payment.2c2p-sandbox.status') && $request->sandbox != 'on'),
            'secret_code' => Rule::requiredIf(!config('payment.2c2p-sandbox.status') && $request->sandbox != 'on'),
            'locale_code' => Rule::requiredIf(!config('payment.2c2p-sandbox.status') && $request->sandbox != 'on'),
        ]);

        //dd($request->sandbox);

        DotenvEditor::setKeys([
            '2C2P_SANDBOX_ENABLE' => $request->sandbox !== null ? 'true' : 'false',
            '2C2P_MERCHANT_ID' => ($request->merchant_id && $request->sandbox == null) ? $request->merchant_id : '',
            '2C2P_CURRENCY_CODE' => ($request->currency_code && $request->sandbox == null) ? $request->currency_code : '',
            '2C2P_SECRET_CODE' => ($request->secret_code && $request->sandbox == null) ? $request->secret_code : '',
            '2C2P_LOCALE_CODE' => ($request->locale_code && $request->sandbox == null) ? $request->locale_code : '',
        ])->save();

        return redirect()->route('admin.payment.2c2p')->with('swal-success', '2C2P Payment Configuration has updated.');
    }

    public function indexStripe()
    {

        if (config('payment.stripe-status') == false) {
            return redirect()->route('admin.payment.general')->with('swal-warning', 'Please enable Stripe payment at General page first.');
        }

        return view('admin.payment.stripe.index');
    }

    public function saveStripe(Request $request)
    {
        $request->validate([
            'currency_code' => 'required',
        ]);

        if(!config('payment.maintenance_mode') && $request->sandbox){
            return redirect()->back()->with('swal-warning', 'Please enable maintenance mode before enabling the sandbox mode.');
        }

        DotenvEditor::setKeys([
            'STRIPE_SANDBOX' => $request->sandbox ? 'true' : 'false',
            'STRIPE_KEY' => $request->stripe_key ?: config('cashier.key'),
            'STRIPE_SECRET' => $request->stripe_secret?: config('cashier.secret'),
            'CASHIER_CURRENCY' => $request->currency_code,
        ])->save();

        return redirect()->route('admin.payment.stripe')->with('swal-success', 'Stripe Payment Configuration has updated.');
    }
}
