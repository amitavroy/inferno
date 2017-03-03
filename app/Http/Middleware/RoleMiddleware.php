<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (Auth::guest()) {
            return redirect('/');
        }

        if (! $request->user()->hasRole($role)) {
            abort(403);
        }

        if ($permission != null && ! $request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
