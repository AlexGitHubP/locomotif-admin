<?php

namespace Locomotif\Admin\Middleware;

use Illuminate\Support\Facades\Auth;
use Locomotif\Admin\Models\Users;
use Closure;

class Authgate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    //redirect to login if user not authenticated. No gate used. 
    public function handle($request, Closure $next, $role)
    {
        
        if(Auth::check()){
            $user = Users::find(Auth::user()->id);
            if(!$user->roles->pluck('name')->contains($role)){
                return redirect('/admin/login');
            }
        }else{
            return redirect('/admin/login');
        }

        
        return $next($request);

    }
}
