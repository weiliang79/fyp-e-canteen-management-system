<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('student_id', Auth::guard('student')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('order.index', compact('orders'));
    }

    public function adminIndex(){
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }

    public function adminOrderDetails(Request $request){
        $order = Order::find($request->order_id);
        return view('admin.order.details', compact('order'));
    }

}
