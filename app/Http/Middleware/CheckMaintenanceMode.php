<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckMaintenanceMode
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
        if (auth()->check() && config('maintenance.maintenace_mode') == 1 && auth()->user()->getUserRole() != User::SUPERADMIN) {
            auth()->logout();
            return redirect()->route('login')->withMessage(trans('messages.under_maintenance'));
        }
        return $next($request);
    }
}
