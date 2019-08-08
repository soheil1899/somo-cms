<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckWriteradmin
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

            $roles = auth()->user()->roles()->get();
            $permissions = array();
            foreach ($roles as $role){
                array_push($permissions, $role->permissions()->get());
            }
            for ($i=0; $i<count($permissions); $i++){
                for($j=0; $j<count($permissions[$i]);$j++){
                    $per = $permissions[$i][$j]['permission'];
                    if( $per == 'add_article' or
                        $per == 'edit_article' or $per == 'delete_article'){
                        return $next($request);
                    }
                }
            }
            return redirect('/dashboard');


        }else{
            return redirect('/');

        }
    }
}
