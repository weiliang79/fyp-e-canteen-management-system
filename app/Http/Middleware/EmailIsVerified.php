<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach($guards as $guard){
            if(Auth::guard($guard)->user()->email == null || Auth::guard($guard)->user()->email_verified_at == null){
                if(Auth::guard($guard)->user()->isAdmin()){
                    return redirect()->route('admin.profile')->with('swal-warning', 'Please enter or update your email address to continue use this system.');
                } else if (Auth::guard($guard)->user()->isFoodseller()){
                    return redirect()->route('food_seller.profile')->with('swal-warning', 'Please enter or update your email address to continue use this system.');
                } else if (Auth::guard($guard)->user()->isStudent()) {
                    return redirect()->route('test')->with('swal-warning', 'Please enter or update your email address to continue use this system.');
                }
            }
        }

        return $next($request);
    }
}
