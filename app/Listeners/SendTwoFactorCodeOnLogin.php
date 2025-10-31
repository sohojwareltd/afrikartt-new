<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Http\Controllers\TwoFactorController;

class SendTwoFactorCodeOnLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        if (!$user) return;

        // Skip if coming from registration endpoints
        $request = request();
        $path = $request->path();
        if (str_starts_with($path, 'register') || str_contains($path, 'vendor-registration')) {
            return;
        }

        // Avoid duplicate if a valid code already exists
        if (!empty($user->two_factor_code) && !empty($user->two_factor_expires_at) && now()->lessThan($user->two_factor_expires_at)) {
            return;
        }

        // Generate and send OTP on successful login
        TwoFactorController::sendOtp($user);
    }
}


