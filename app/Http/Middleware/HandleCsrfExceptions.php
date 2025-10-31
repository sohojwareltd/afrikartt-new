<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

class HandleCsrfExceptions extends Middleware
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
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            // Log the CSRF token mismatch for debugging
            \Log::warning('CSRF Token Mismatch', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->session()->getId(),
                'has_session' => $request->hasSession(),
                'session_token' => $request->session()->token(),
                'request_token' => $request->input('_token') ?: $request->header('X-CSRF-TOKEN'),
            ]);

            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'CSRF token mismatch. Please refresh the page and try again.',
                    'code' => 419
                ], 419);
            }

            // For regular requests, redirect back with error
            return redirect()->back()
                ->withInput($request->except('_token'))
                ->withErrors(['csrf' => 'Your session has expired. Please try again.']);
        }
    }
}
