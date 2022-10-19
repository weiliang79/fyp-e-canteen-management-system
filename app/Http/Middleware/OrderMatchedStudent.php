<?php

namespace App\Http\Middleware;

use App\Models\Order;
use App\Models\Student;
use Auth;
use Closure;
use Illuminate\Http\Request;

class OrderMatchedStudent
{
    /**
     * Handle an incoming request if the order matched the student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        $guards = empty($guards) ? [null] : $guards;
        $order = Order::find($request->order_id);
        $student = Student::find(Auth::guard($guard)->user()->id);

        if($order->student_id !== $student->id){
            abort(403);
        }

        return $next($request);
    }
}
