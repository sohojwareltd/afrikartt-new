<?php

namespace App\Services\Shipping;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EashShipProvider
{

    private $accessToken;
    private $endpoint = "https://public-api.easyship.com/2024-09/";

    public function __construct()
    {
        $this->setAccessToken();
    }

    private function setAccessToken()
    {
        $this->accessToken =  config('services.eash_ship.access_token');
    }

    public function getRatesPayload($shipping, $packages)
    {

        return [
            "origin_address" => [
                "line_1" => "2251 SW Binford Lake Parkway",
                "line_2" => "Gresham",
                "state" => "OR",
                "city" => "Gresham",
                "postal_code" => "97080",
                "country_alpha2" => "US",
                "company_name" => "Afrikartt",
                "contact_name" => "Afrikartt",
                "contact_phone" => "555-123-4567",
                "contact_email" => "info@afrikartt.com",
            ],
            "destination_address" => [
                "city" => $shipping['city'],
                "company_name" => "",
                "contact_email" =>  $shipping['email'],
                "contact_name" => $shipping['firstName'] . ' ' . $shipping['lastName'],
                "contact_phone" => $shipping['phone'],
                "country_alpha2" => $shipping['country_code'],

                "line_1" => $shipping['address_line'],

                "postal_code" => $shipping['post_code'],
                "state" => $shipping['state_code']
            ],
            "set_as_residential" => true,
            "incoterms" => "DDP",
            "courier_settings" => [
                "show_courier_logo_url" => true,
                "apply_shipping_rules" => false
            ],
            "shipping_settings" => [
                "units" => [
                    "weight" => "kg",
                    "dimensions" => "cm"
                ],
                "output_currency" => "USD"
            ],
            "parcels" => [
               ... $packages->map(function ($package) {
                    return [
                        "total_actual_weight" => (float) $package->weight() * $package->pivot->quantity,

                        "items" => [

                            [
                                "contains_battery_pi966" => $package->contains_battery_pi966(),
                                "contains_battery_pi967" => $package->contains_battery_pi967(),
                                "contains_liquids" => $package->contains_liquids(),
                                "origin_country_alpha2" => $package->origin_country_alpha2(),
                                "hs_code" => $package->hs_code(),
                                "description" => $package->description(),
                                "quantity" => $package->pivot->quantity,
                                "declared_currency" => "USD",

                                "declared_customs_value" => 1,
                                "actual_weight" => (float) $package->weight(),
                                "dimensions" => [
                                    "length" => (int) $package->length(),
                                    "width" => (int) $package->width(),
                                    "height" => (int) $package->height()
                                ],
                            ]



                        ]
                    ];
                })->toArray()

            ]
        ];
    }

    // public function getRatesPayload($shipping, $packages)
    // {

    //     return [
    //         "origin_address" => [
    //             "line_1" => "2251 SW Binford Lake Parkway",
    //             "line_2" => "Gresham",
    //             "state" => "OR",
    //             "city" => "Gresham",
    //             "postal_code" => "97080",
    //             "country_alpha2" => "US",
    //             "company_name" => "Afrikartt",
    //             "contact_name" => "Afrikartt",
    //             "contact_phone" => "555-123-4567",
    //             "contact_email" => "info@afrikartt.com",
    //         ],
    //         "destination_address" => [
    //             "city" => "Wasilla",
    //             "company_name" => "",
    //             "contact_email" => "thisiskazi@gmail.com",
    //             "contact_name" => "Kazi Thabit",
    //             "contact_phone" => "808-852-5935",
    //             "country_alpha2" => "US",
    //             "line_2" => "940 Goldendale Dr",
    //             "line_1" => "940 Goldendale Dr, Wasilla, Alaska 99654, USA",

    //             "postal_code" => "99654",
    //             "state" => "AK"
    //         ],
    //         "set_as_residential" => true,
    //         "incoterms" => "DDP",
    //         "courier_settings" => [
    //             "show_courier_logo_url" => true,
    //             "apply_shipping_rules" => false
    //         ],
    //         "shipping_settings" => [
    //             "units" => [
    //                 "weight" => "kg",
    //                 "dimensions" => "cm"
    //             ],
    //             "output_currency" => "USD"
    //         ],
    //         "parcels" => [

    //             [
    //                 "total_actual_weight" => $packages->map(function ($package) {
    //                     return $package->weight() * $package->pivot->quantity;
    //                 })->sum(),

    //                 "items" => [
    //                     ...$packages->map(function ($package) {
    //                         return [

    //                             "hs_code" => $package->hs_code(),
    //                             "contains_battery_pi966" => $package->contains_battery_pi966(),
    //                             "contains_battery_pi967" => $package->contains_battery_pi967(),
    //                             "contains_liquids" => $package->contains_liquids(),
    //                             "origin_country_alpha2" => $package->origin_country_alpha2(),
    //                             "quantity" => $package->pivot->quantity,
    //                             "declared_currency" => "USD",

    //                             "declared_customs_value" => 1,
    //                             "actual_weight" => $package->weight() * $package->pivot->quantity,
    //                             "dimensions" => [
    //                                 "length" => $package->length() * $package->pivot->quantity,
    //                                 "width" => $package->width() * $package->pivot->quantity,
    //                                 "height" => $package->height() * $package->pivot->quantity
    //                             ],
    //                         ];
    //                     })->toArray()


    //                 ]
    //             ]


    //         ]
    //     ];
    // }

    public function getRates($shipping, $packages)
    {

        $payload = $this->getRatesPayload($shipping, $packages);

        Log::info('=========================================');
        Log::info('=========================================');
        Log::info('EashShipProvider getRates payload');
        Log::info(json_encode($payload));
        Log::info('EashShipProvider getRates payload end');
        Log::info('=========================================');
        Log::info('=========================================');

        $http = Http::withHeaders([
            'authorization' => 'Bearer ' . $this->accessToken,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ]);
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }
        $response = $http->post($this->endpoint . 'rates', $payload);

        return $response->json();
    }

    public function getCategories()
    {
        $http = Http::withHeaders([
            'authorization' => 'Bearer ' . $this->accessToken,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ]);
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }
        $response = $http->get($this->endpoint . 'item_categories');

        return $response->json();
    }

    protected function getShipmentPayload(Order $order)
    {

        $shipping = json_decode($order->shipping, true);
        return [
            "origin_address" => [
                "line_1" => "2251 SW Binford Lake Parkway",
                "line_2" => "Gresham",
                "state" => "OR",
                "city" => "Gresham",
                "postal_code" => "97080",
                "country_alpha2" => "US",
                "company_name" => "Afrikartt",
                "contact_name" => "Afrikartt",
                "contact_phone" => "555-123-4567",
                "contact_email" => "info@afrikartt.com",
            ],
            "destination_address" => [
                "city" => $shipping['city'],
                "company_name" => "",
                "contact_email" =>  $shipping['email'],
                "contact_name" => $shipping['firstName'] . ' ' . $shipping['lastName'],
                "contact_phone" => $shipping['phone'],
                "country_alpha2" => $shipping['country_code'],
                "line_1" => $shipping['address_line'],
                "postal_code" => $shipping['post_code'],
                "state" => $shipping['state_code']
            ],
            "order_data" => [
                "platform_name" => "afrikartt",
                "platform_order_number" => $order->id,
                "order_created_at" => $order->created_at,
                "order_tag_list" => $order->products->pluck('name')->toArray(),
            ]
        ];
    }

    public function createShipment(Order $order)
    {
        $payload = $this->getShipmentPayload($order);
        $http = Http::withHeaders([
            'authorization' => 'Bearer ' . $this->accessToken,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ]);
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }
        $response = $http->post($this->endpoint . 'shipments', $payload);

        return $response->json();
    }
}
