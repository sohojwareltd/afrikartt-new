<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();
        if (method_exists($user, 'role') && $user->role && $user->role->name === 'user') {
            return $next($request);
        }

        abort(403, 'Forbidden: User access only.');
    }
}


