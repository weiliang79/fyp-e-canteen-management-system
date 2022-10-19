<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckForPaymentMaintenanceMode
{
    /**
     * Handle an incoming request if payment is under maintenance mode or the student is a sandbox student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (config('payment.maintenance_mode') && !Auth::guard($guard)->user()->is_a_sandbox_student) {
                abort(503);
            }
        }

        return $next($request);
    }
}
