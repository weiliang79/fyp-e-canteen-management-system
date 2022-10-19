<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnabledForAllPayment
{
    /**
     * Handle an incoming request if all payment type is enabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('payment.2c2p-status') == false && config('payment.stripe-status') == false){
            abort(503);
        }

        return $next($request);
    }
}
