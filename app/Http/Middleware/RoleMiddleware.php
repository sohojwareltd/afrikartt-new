<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            if ($request->is('vendor') || $request->is('vendor/*')) {
                return $next($request);
            }
            return redirect()->guest(route('login'));
        }
        if (Auth::user()->role->name !== $role) {
            abort(403, 'Forbidden: You do not have the required role.');
        }
        return $next($request);
    }
}
