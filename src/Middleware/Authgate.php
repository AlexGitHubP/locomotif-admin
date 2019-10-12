<?php

namespace Locomotif\Admin\Middleware;

use Illuminate\Auth\Middleware\Authenticate as LocomotifLoginMiddleware;
use Closure;

class Authgate extends LocomotifLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin/login');
        }
    }
}
