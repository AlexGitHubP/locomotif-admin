<?php

namespace Locomotif\Admin\Middleware;

use Illuminate\Support\Facades\Auth;
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
    public function handle($request, Closure $next, $guard = null)
    {
        
        if (!Auth::check()) {
            if (!$request->expectsJson()) {
                return redirect('/admin/login');
            }
        }

        return $next($request);

    }
}
