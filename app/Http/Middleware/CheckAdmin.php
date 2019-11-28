<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Permissions;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{

    use Permissions;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $per = $this->getpermission(auth()->user()->roles()->get());
            if (count($per) > 0){
                return $next($request);
            }else{
                return redirect('/home');
            }

        } else {
            return redirect('/');

        }
    }
}
