<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }
        if (Auth::user()->role->name == 'vendor') {
            return $next($request);
        }

        if (config('app.disable_2fa', false)) {
            return $next($request);
        }

        $routeName = optional($request->route())->getName();
        $path = $request->path();

        $allowedNames = [
            'twofactor.challenge',
            'twofactor.verify',
            'twofactor.resend',
            'logout',
            'password.request',
            'password.email',
            'password.reset',
            'password.update',
        ];
        $isAllowed = in_array($routeName, $allowedNames, true)
            || str_starts_with($path, 'assets/')
            || str_starts_with($path, 'storage/')
            || str_starts_with($path, 'build/')
            || str_starts_with($path, 'favicon');

        $user = Auth::user();
        $hasPendingTwoFactor = !empty($user->two_factor_code) && !empty($user->two_factor_expires_at);

        if ($hasPendingTwoFactor && !$isAllowed && env('APP_ENV') === 'production') {
            if (!session()->has('intended_after_2fa')) {
                session(['intended_after_2fa' => $request->fullUrl()]);
            }
            return redirect()->route('twofactor.challenge');
        }

        return $next($request);
    }
}
