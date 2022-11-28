<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
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
            ->where('status', '>=', Order::PAYMENT_SUCCESS)
            ->sum('total_price');

            return view('admin.home', compact('orderCount', 'allOrderCount', 'sales'));
            
        } else if (Auth::user()->isFoodSeller()) {

            $startDate = Carbon::today()->firstOfMonth();
            $endDate = $startDate->copy();
            $endDate->endOfMonth();

            $startTime = Carbon::today()->startOfDay();
            $endTime = $startTime->copy();
            $endTime->endOfDay();

            $user = User::find(Auth::user()->id);
            $products = $user->store->products()->pluck('id')->toArray();

            $orderCount = Order::whereHas('orderDetails', function ($query) use ($products) {
                $query->whereIn('product_id', $products)->where('is_pickup', true);
            })->whereBetween('pick_up_start', [$startTime, $endTime])->count();

            $allOrderCount = Order::whereHas('orderDetails', function ($query) use ($products) {
                $query->whereIn('product_id', $products);
            })->whereBetween('pick_up_start', [$startTime, $endTime])->count();

            $sales = OrderDetail::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', '>=', Order::PAYMENT_SUCCESS)->whereBetween('created_at', [$startDate, $endDate]);
            })->whereIn('product_id', $products)->sum('price');

            return view('food_seller.home', compact('orderCount', 'allOrderCount', 'sales'));
        }

        Auth::logout();
        return redirect()->route('login')->with('swal-warning', 'Unknown error, please contact administrator if it happen again.');
    }
}
