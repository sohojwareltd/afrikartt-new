<?php

namespace App\Services;

use App\Setting\Settings;
use Illuminate\Support\Facades\Http;

class Payouts
{

    public static function token()
    {

        $client_id = Settings::setting('paypal_client_id');
        $secret_id = Settings::setting('paypal_secret_id');
        if (Settings::setting('paypal_sandbox')) {
            $endpoint =  'https://api.sandbox.paypal.com/v1/oauth2/token';
        } else {
            $endpoint =  'https://api-m.paypal.com/v1/oauth2/token';
        }

        $res = Http::withBasicAuth($client_id, $secret_id)
            ->asForm()
            ->post($endpoint, ['grant_type' => 'client_credentials']);

        return json_decode($res->body())->access_token;
    }
}