<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {


        // Return Not Authorized error, if user has not logged in
        if (! Auth::check()) {
            App::abort(401);
        }

        $roles = explode('|', $roles);
        // if user has given role, continue processing the request

      
        if (Auth::user()->authorizeRoles($roles)) {
            return $next($request);
        }
        // user didn't have any of required roles, return Forbidden error
        App::abort(403);
    }
}
