<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->shop) {
            if (auth()->user()->shop->status == 1) {

                return $next($request);
            }
            return redirect()->route('vendor.verification');
        }
        return redirect('/register-as-seller');
    }
}
