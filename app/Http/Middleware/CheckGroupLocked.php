<?php

namespace App\Http\Middleware;

use Closure;

class CheckGroupLocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->check() && !auth()->user()->roles()->firstOrFail()->isActive()) {
            auth()->logout();
            return redirect()->route('login')->withMessage(trans('messages.locked'));
        }
        return $next($request);
    }
}
