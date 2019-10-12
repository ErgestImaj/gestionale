<?php

namespace App\Http\Middleware;

use App\Traits\RedirectUsersToDashboard;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    use RedirectUsersToDashboard;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            return redirect(
               $this->redirect_user_to_specific_dashboard(\auth()->user()->getUserRole())
            );
        }

        return $next($request);
    }
}
