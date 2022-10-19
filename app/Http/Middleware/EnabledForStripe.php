<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnabledForStripe
{
    /**
     * Handle an incoming request if Stripe payment is enabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!config('payment.stripe-status')){
            abort(503);
        }
        return $next($request);
    }
}
