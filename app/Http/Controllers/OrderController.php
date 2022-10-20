<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Store;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Show the student's made orders.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Order::where('student_id', Auth::guard('student')->user()->id)->orderBy('created_at', 'desc')->paginate(15);
        return view('order.index', compact('orders'));
    }

    /**
     * Show all the orders.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminIndex()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the given order details.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminOrderDetails(Request $request)
    {
        $order = Order::find($request->order_id);
        return view('admin.order.details', compact('order'));
    }

    /**
     * Show all the orders related to the store.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function foodSellerIndex()
    {
        $productIds = Store::where('user_id', Auth::user()->id)->first()->products()->pluck('id')->toArray();
        $orders = Order::whereHas('orderDetails', function ($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->orderBy('created_at', 'desc')->get();
        return view('food_seller.order.index', compact('orders'));
    }

    /**
     * Show the given order details related to the store.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function foodSellerDetails(Request $request)
    {
        $productIds = Store::where('user_id', Auth::user()->id)->first()->products()->pluck('id')->toArray();
        $order = Order::find($request->order_id);
        $details = OrderDetail::where('order_id', $order->id)
            ->whereIn('product_id', $productIds)
            ->get();
        $detailsOtherStore = OrderDetail::where('order_id', $order->id)
            ->whereNotIn('product_id', $productIds)
            ->get();
        return view('food_seller.order.details', compact('order', 'details', 'detailsOtherStore'));
    }

}
