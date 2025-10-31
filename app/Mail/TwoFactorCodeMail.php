<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function build(): self
    {
        $appName = Config::get('app.name', 'Application');
        return $this->subject("{$appName} Login Verification Code")
            ->view('emails.twofactor')
            ->with(['code' => $this->code]);
    }
}


