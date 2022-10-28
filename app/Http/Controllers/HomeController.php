<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){

            $startDate = Carbon::today()->firstOfMonth();
            $endDate = $startDate->copy();
            $endDate->endOfMonth();

            $orderCount = Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', Order::PICKUP_ALL)
                ->count();

            $allOrderCount = Order::whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $sales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', Order::PAYMENT_SUCCESS)
            ->sum('total_price');

            return view('admin.home', compact('orderCount', 'allOrderCount', 'sales'));
            
        } else if (Auth::user()->isFoodSeller()) {

            $startDate = Carbon::today()->firstOfMonth();
            $endDate = $startDate->copy();
            $endDate->endOfMonth();

            $startTime = Carbon::today()->startOfDay();
            $endTime = $startTime->copy();
            $endTime->endOfDay();

            $orderCount = OrderDetail::whereHas('order', function ($query) use ($startTime, $endTime) {
                $query->whereBetween('pick_up_start', [$startTime, $endTime]);
            })->where('is_pickup', true)->count();

            $allOrderCount = OrderDetail::whereHas('order', function ($query) use ($startTime, $endTime) {
                $query->whereBetween('pick_up_start', [$startTime, $endTime]);
            })->count();

            $sales = OrderDetail::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', Order::PAYMENT_SUCCESS)
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })->sum('price');

            //dd($startTime, $endTime, $orderCount, $allOrderCount);

            return view('food_seller.home', compact('orderCount', 'allOrderCount', 'sales'));
        }

        Auth::logout();
        return redirect()->route('login')->with('swal-warning', 'Unknown error, please contact administrator if it happen again.');
    }
}
