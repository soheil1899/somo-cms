<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $userRole = Auth::user()->roles()->first()->role;

            if($userRole =='superadmin'){
                return $next($request);
            }else{
                return redirect('/dashboard');
            }


        }else{
            return redirect('/');

        }
    }
}
