<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Payouts
{

    public static function token()
    {
    ;
        $client_id = 'ASEIeZ0uWYy1q8iGe-LJvFjRqVAK4wg5WtW5dFpKucIhhNFeutYGtiKV2M1kiLoGMb2T5CLmbXpN6Fgz';
        $secret_id = 'EN3248ng0HkjmIjwW3iEfxhQL8ll_YeHBoJsYzk-VgXKYgg6c-z8taDRJfn2OohnKdVK3o5m3cRGnM30';
        $endpoint = ['local' => 'https://api.sandbox.paypal.com/v1/oauth2/token', 'production' => 'https://api-m.paypal.com/v1/oauth2/token'];
        $res = Http::withBasicAuth($client_id, $secret_id)
            ->asForm()
            ->post($endpoint[env('PAYPAL_MODE')], ['grant_type' => 'client_credentials']);
            // dd($res->body());
        return (json_decode($res->body())->access_token);
    }
}
