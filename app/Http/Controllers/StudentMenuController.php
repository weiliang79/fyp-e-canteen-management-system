<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OptionDetail;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMenuController extends Controller
{
    public function index(Request $request)
    {
        $allStores = Store::all();
        $allCategories = ProductCategory::all();

        if ($request->has('stores') || $request->has('categories')) {

            if ($request->has('stores') && $request->has('categories')) {
                $products = Product::where('status', true)
                    ->whereIn('store_id', $request->stores)
                    ->orWhereIn('category_id', $request->categories)
                    ->get();
            } else if ($request->has('categories')) {
                $products = Product::where('status', true)
                    ->whereIn('category_id', $request->categories)
                    ->get();
            } else {
                $products = Product::where('status', true)
                    ->whereIn('store_id', $request->stores)
                    ->get();
            }

            //dd($products);
        } else {
            $products = Product::where('status', true)->get();
        }

        return view('menu.index', compact('allStores', 'allCategories', 'products'));
    }

    public function getFoodOptions(Request $request)
    {
        $product = Product::find($request->id);
        $options = $product->productOptions;
        $details = array();

        foreach ($options as $option) {
            $temp = $option->optionDetails;
            foreach ($temp as $detail) {
                array_push($details, $detail);
            }
        }

        return response()->json([
            'product' => $product,
            'options' => $product->productOptions,
            'details' => $details,
        ]);
    }

    public function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $totalPrice = Product::find($request->product_id)->price;

        foreach($request->options as $value){
            foreach($value as $key1 => $value1){
                $totalPrice = $totalPrice + OptionDetail::find($value1)->extra_price;
            }
        }

        Cart::create([
            'student_id' => Auth::guard('student')->user()->id,
            'product_id' => $request->product_id,
            'product_options' => $request->options,
            'price' => $totalPrice,
            'notes' => $request->notes,
        ]);

        return response()->json('Add to cart successful.');
    }

    public function cartIndex(){
        $carts = Cart::where('student_id', Auth::guard('student')->user()->id)->get();

        $userRestTimes = Student::find(Auth::guard('student')->user()->id)->restTimes()->get();
        
        //select the dates within two weeks
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addWeeks(2);

        $restDates = array();

        while($startDate->lt($endDate)){

            foreach($userRestTimes as $rest){
                if($rest->day_id === $startDate->dayOfWeek){
                    
                    $startTime = Carbon::createFromFormat('Y-m-d H:i A', $startDate->format('Y-m-d') . $rest->start_time);
                    $endTime = Carbon::createFromFormat('Y-m-d H:i A', $startDate->format('Y-m-d') . $rest->end_time);

                    if($startTime->gt(Carbon::now())){
                        $string = $startTime->format('Y-m-d h:ia') . ' to ' . $endTime->format('h:ia');

                        $restDates[$startTime->timestamp . '->' . $endTime->timestamp] = $string;
                    }

                }
            }

            $startDate->addDay();
        }

        return view('menu.cart', compact('carts', 'restDates'));
    }

    public function deleteCartItem(Request $request){

        $request->validate([
            'product_id' => 'required',
            'time_created' => 'required',
        ]);

        Cart::where('student_id', Auth::guard('student')->user()->id)
            ->where('product_id', $request->product_id)
            ->where('created_at', $request->time_created)
            ->delete();

        return response()->json('The product has successful removed from cart.');
    }

    public function createOrder(Request $request){

        $request->validate([
            'restTime' => 'required',
        ]);

        $restTimes = explode('->', $request->restTime);
        $student = Student::find(Auth::guard('student')->user()->id);
        $carts = Cart::where('student_id', $student->id)->get();

        //dd($request, $restTimes, $carts, $carts->sum('price'));

        $order = Order::create([
            'student_id' => Auth::guard('student')->user()->id,
            'pick_up_start' => $restTimes[0],
            'pick_up_end' => $restTimes[1],
            'total_price' => $carts->sum('price'),
            'status' => Order::PAYMENT_PENDING,
            'is_sandbox_order' => $student->is_a_sandbox_student,
        ]);

        foreach($carts as $cart){
            $order->orderDetails()->create([
                'product_id' => $cart->product_id,
                'product_options' => $cart->product_options,
                'price' => $cart->price,
                'notes' => $cart->notes,
            ]);

            Cart::where('student_id', $cart->student_id)
                ->where('product_id', $cart->product_id)
                ->where('created_at', $cart->created_at)
                ->delete();
        }

        return redirect()->route('student.checkout', ['order_id' => $order->id]);
    }

}
