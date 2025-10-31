<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectToAppLoginForPanels
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            $loginUrl = route('login', ['redirect' => $request->fullUrl()]);
            return redirect()->guest($loginUrl);
        }

        return $next($request);
    }
}


