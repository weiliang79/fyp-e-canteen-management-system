<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnabledFor2c2p
{
    /**
     * Handle an incoming request if 2C2P payment is enabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!config('payment.2c2p-status')){
            abort(503);
        }
        return $next($request);
    }
}
