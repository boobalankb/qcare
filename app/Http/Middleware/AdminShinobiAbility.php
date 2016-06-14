<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminShinobiAbility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $permissions = '', $validateAll = false)
    {
        if(!$user = Auth::guard('admin')->user()) {
            abort(403, 'Unauthorized action.');
        }
        
        if(!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
