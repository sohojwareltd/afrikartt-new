<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class UPSService
{
    private $clientId;
    private $clientSecret;
    private $accountNumber;
    private $baseUrl;
    private $isProduction;
    private $httpClient;

    public function __construct()
    {
        $this->clientId = config('services.ups.client_id') ?? env('UPS_CLIENT_ID');
        $this->clientSecret = config('services.ups.client_secret') ?? env('UPS_CLIENT_SECRET');
        $this->accountNumber = config('services.ups.account_number') ?? env('UPS_ACCOUNT_NUMBER');
        $this->isProduction = config('services.ups.production', false);

        // Set base URL based on environment
        $this->baseUrl = $this->isProduction
            ? 'https://onlinetools.ups.com'
            : 'https://wwwcie.ups.com';

        $this->httpClient = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }

    /**
     * Get OAuth2 access token
     */
    public function getAccessToken(): string
    {
        $cacheKey = 'ups_access_token';

        if (Cache::has($cacheKey)) {
            $tokenData = Cache::get($cacheKey);
            if (time() < $tokenData['expires_at']) {
                return $tokenData['access_token'];
            }
        }

        try {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post($this->baseUrl . '/security/v1/oauth/token', [
                    'grant_type' => 'client_credentials',
                ]);

            if (!$response->successful()) {
                throw new Exception('Failed to get UPS access token: ' . $response->body());
            }

            $tokenData = $response->json();
            $expiresAt = time() + ($tokenData['expires_in'] ?? 3600) - 300;

            Cache::put($cacheKey, [
                'access_token' => $tokenData['access_token'],
                'expires_at' => $expiresAt,
            ], $expiresAt - time());

            return $tokenData['access_token'];
        } catch (Exception $e) {
            Log::error('UPS OAuth token error: ' . $e->getMessage());
            throw new Exception('Failed to authenticate with UPS: ' . $e->getMessage());
        }
    }

    /**
     * Get shipping rates
     */
    public function getRates(array $fromAddress, array $toAddress, array $packageDetails): array
    {
    
        $accessToken = $this->getAccessToken();
        $this->validateAddress($fromAddress, 'from');
        $this->validateAddress($toAddress, 'to');
        foreach ($packageDetails as $package) {
            $this->validatePackageDetails($package);
        }

        $payload = [
            'RateRequest' => [
                'Request' => [
                    'RequestOption' => 'Shop',
                    'TransactionReference' => [
                        'CustomerContext' => 'Rate Request'
                    ]
                ],
                'Shipment' => [
                    'Shipper' => $this->formatAddress($fromAddress, true),
                    'ShipTo' => $this->formatAddress($toAddress, true),
                    'ShipFrom' => $this->formatAddress($fromAddress, true),

                    // Required Service code (03 = Ground, change if needed)
                    'Service' => [
                        'Code' => '03',
                        'Description' => 'Ground'
                    ],

                    'Package' => array_map(function ($package) {
                        return [
                            'PackagingType' => [
                                'Code' => '02', // Customer Supplied Package
                                'Description' => 'Package'
                            ],
                            'Dimensions' => [
                                'UnitOfMeasurement' => ['Code' => 'IN'],
                                'Length' => (string) $package['length'],
                                'Width'  => (string) $package['width'],
                                'Height' => (string) $package['height']
                            ],
                            'PackageWeight' => [
                                'UnitOfMeasurement' => ['Code' => 'LBS'],
                                'Weight' => (string) $package['weight']
                            ]
                        ];
                    }, $packageDetails)
                ]
            ]
        ];
      

        $response = $this->httpClient
            ->withToken($accessToken)
            ->withHeaders(['transId' => (string) Str::uuid()])
            ->post($this->baseUrl . '/api/rating/v1/Shop', $payload);

        if (!$response->successful()) {
            throw new Exception('UPS Rate request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Create shipment using UPS Ship API v2409
     */
    public function createShipment(array $fromAddress, array $toAddress, array $packageDetails, string $serviceCode): array
    {
        // Get access token
        $accessToken = $this->getAccessToken();

        // Validate input
        // $this->validateAddress($fromAddress, 'from');
        // $this->validateAddress($toAddress, 'to');
        // $this->validatePackageDetails($packageDetails);

        // UPS Ship API endpoint
        $endpoint = $this->baseUrl . '/api/shipments/v2409/ship';

        // Build payload according to UPS Ship API v2409 specification
        $payload = [
            'ShipmentRequest' => [
                'Request' => [
                    'RequestOption' => 'nonvalidate',
                    'TransactionReference' => [
                        'CustomerContext' => 'Shipment Request - ' . date('Y-m-d H:i:s')
                    ]
                ],
                'Shipment' => [
                    'Description' => $packageDetails['description'] ?? 'Package',
                    'Shipper' => $this->formatShipperAddress($fromAddress),
                    'ShipTo' => $this->formatShipToAddress($toAddress),
                    'ShipFrom' => $this->formatShipFromAddress($fromAddress),
                    'PaymentInformation' => [
                        'ShipmentCharge' => [
                            [
                                'Type' => '01', // Transportation charges
                                'BillShipper' => [
                                    'AccountNumber' => $this->accountNumber
                                ]
                            ]
                        ]
                    ],
                    'Service' => [
                        'Code' => $serviceCode,
                        'Description' => $this->getServiceDescription($serviceCode)
                    ],
                    'Package' => array_map(function ($package) {
                      return  [
                            'Description' => 'Package',
                            'Packaging' => [
                                'Code' => '02', // Customer Supplied Package
                                'Description' => 'Package'
                            ],
                            'Dimensions' => [
                                'UnitOfMeasurement' => [
                                    'Code' => 'IN',
                                    'Description' => 'Inches'
                                ],
                                'Length' => (string) $package['length'],
                                'Width' => (string) $package['width'],
                                'Height' => (string) $package['height']
                            ],
                            'PackageWeight' => [
                                'UnitOfMeasurement' => [
                                    'Code' => 'LBS',
                                    'Description' => 'Pounds'
                                ],
                                'Weight' => (string) $package['weight']
                            ]
                            ];
                    }, $packageDetails)
                ],
                'LabelSpecification' => [
                    'LabelImageFormat' => [
                        'Code' => 'GIF',
                        'Description' => 'GIF'
                    ],
                    'LabelStockSize' => [
                        'Height' => '6',
                        'Width' => '4'
                    ]
                ]
            ]
        ];

        // Send request
        try {
            $response = $this->httpClient
                ->timeout(60) // 60 seconds timeout
                ->withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'transId' => (string) Str::uuid(),
                    'transactionSrc' => 'SohojEcommerce',
                    'Accept' => 'application/json',
                ])
                ->post($endpoint, $payload);

            // Log request and response for debugging
            Log::info('UPS Shipment request payload', $payload);
            Log::info('UPS Shipment response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if (!$response->successful()) {
                $errorBody = $response->body();
                Log::error('UPS Shipment request failed', [
                    'status' => $response->status(),
                    'body' => $errorBody
                ]);
                throw new Exception('UPS Shipment request failed: ' . $errorBody);
            }

            $responseData = $response->json();

            // Extract important shipment information
            if (isset($responseData['ShipmentResponse']['ShipmentResults'])) {
                $shipmentResults = $responseData['ShipmentResponse']['ShipmentResults'];
                return [
                    'success' => true,
                    'tracking_number' => $shipmentResults['ShipmentIdentificationNumber'] ?? null,
                    'label' => $shipmentResults['PackageResults'][0]['ShippingLabel']['GraphicImage'] ?? null,
                    'total_cost' => $shipmentResults['ShipmentCharges']['TotalCharges']['MonetaryValue'] ?? null,
                    'currency' => $shipmentResults['ShipmentCharges']['TotalCharges']['CurrencyCode'] ?? 'USD',
                    'raw_response' => $responseData
                ];
            }

            return [
                'success' => true,
                'raw_response' => $responseData
            ];
        } catch (\Exception $e) {
            Log::error('UPS Shipment error: ' . $e->getMessage());
            throw new Exception('Failed to create UPS shipment: ' . $e->getMessage());
        }
    }


    /**
     * Track shipment
     */
    public function trackShipment(string $trackingNumber): array
    {
        $accessToken = $this->getAccessToken();

        $response = $this->httpClient
            ->withToken($accessToken)
            ->withHeaders(['transId' => (string) Str::uuid()])
            ->get($this->baseUrl . '/api/track/v1/details/' . $trackingNumber, [
                'locale' => 'en_US',
                'returnSignature' => 'true'
            ]);

        if (!$response->successful()) {
            throw new Exception('UPS Tracking request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Schedule pickup
     */
    public function schedulePickup(array $pickupAddress, array $packageDetails, string $pickupDate): array
    {
        $accessToken = $this->getAccessToken();

        $payload = [
            'PickupCreationRequest' => [
                'RatePickupIndicator' => 'Y',
                'AccountNumber' => ['Value' => $this->accountNumber],
                'PickupAddress' => $this->formatAddress($pickupAddress, true),
                'PickupDateInfo' => [
                    'PickupDate' => date('Y-m-d', strtotime($pickupDate)),
                    'ReadyTime' => '09:00',
                    'CloseTime' => '17:00'
                ],
                'Package' => [[
                    'PackagingType' => ['Code' => '02'],
                    'Dimensions' => [
                        'UnitOfMeasurement' => ['Code' => 'IN'],
                        'Length' => $packageDetails['length'],
                        'Width' => $packageDetails['width'],
                        'Height' => $packageDetails['height']
                    ],
                    'PackageWeight' => [
                        'UnitOfMeasurement' => ['Code' => 'LBS'],
                        'Weight' => $packageDetails['weight']
                    ]
                ]]
            ]
        ];

        $response = $this->httpClient
            ->withToken($accessToken)
            ->withHeaders(['transId' => (string) Str::uuid()])
            ->post($this->baseUrl . '/api/pickupcreation/v1/pickups', $payload);

        if (!$response->successful()) {
            throw new Exception('UPS Pickup request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Format shipper address for shipment
     */
    private function formatShipperAddress(array $address): array
    {
        $formatted = [
            'Name' => $address['name'] ?? 'Shipper',
            'AttentionName' => $address['attention_name'] ?? $address['name'] ?? 'Shipper',
            'TaxIdentificationNumber' => $address['tax_id'] ?? null,
            'Phone' => [
                'Number' => $address['phone'] ?? null
            ],
            'FaxNumber' => $address['fax'] ?? null,
            'Address' => [
                'AddressLine' => [$address['address_line']],
                'City' => $address['city'],
                'StateProvinceCode' => $address['state'],
                'PostalCode' => $address['postal_code'],
                'CountryCode' => $address['country_code'] ?? 'US'
            ],
            'ShipperNumber' => $this->accountNumber
        ];

        // Remove null values
        return array_filter($formatted, function ($value) {
            return $value !== null;
        });
    }

    /**
     * Format ship-to address for shipment
     */
    private function formatShipToAddress(array $address): array
    {
        $formatted = [
            'Name' => $address['name'] ?? 'Recipient',
            'AttentionName' => $address['attention_name'] ?? $address['name'] ?? 'Recipient',
            'Phone' => [
                'Number' => $address['phone'] ?? null
            ],
            'Address' => [
                'AddressLine' => [$address['address_line']],
                'City' => $address['city'],
                'StateProvinceCode' => $address['state'],
                'PostalCode' => $address['postal_code'],
                'CountryCode' => $address['country_code'] ?? 'US'
            ]
        ];

        // Remove null values
        return array_filter($formatted, function ($value) {
            return $value !== null;
        });
    }

    /**
     * Format ship-from address for shipment
     */
    private function formatShipFromAddress(array $address): array
    {
        $formatted = [
            'Name' => $address['name'] ?? 'Shipper',
            'AttentionName' => $address['attention_name'] ?? $address['name'] ?? 'Shipper',
            'Phone' => [
                'Number' => $address['phone'] ?? null
            ],
            'Address' => [
                'AddressLine' => [$address['address_line']],
                'City' => $address['city'],
                'StateProvinceCode' => $address['state'],
                'PostalCode' => $address['postal_code'],
                'CountryCode' => $address['country_code'] ?? 'US'
            ]
        ];

        // Remove null values
        return array_filter($formatted, function ($value) {
            return $value !== null;
        });
    }

    /**
     * Get service description by code
     */
    public function getServiceDescription(string $serviceCode): string
    {
        $services = [
            '01' => 'Next Day Air',
            '02' => '2nd Day Air',
            '03' => 'Ground',
            '12' => '3 Day Select',
            '13' => 'Next Day Air Saver',
            '14' => 'Next Day Air Early A.M.',
            '15' => 'UPS Express',
            '22' => 'UPS Standard',
            '32' => 'UPS Express Plus',
            '33' => 'UPS Express',
            '41' => 'UPS Express Early',
            '42' => 'UPS Express',
            '44' => 'UPS Express Plus',
            '54' => 'UPS Express 12:00',
            '59' => '2nd Day Air A.M.',
            '65' => 'UPS Saver',
            '66' => 'UPS Worldwide Express Freight',
            '70' => 'UPS Access Point Economy',
            '71' => 'UPS Worldwide Express Freight Midday',
            '74' => 'UPS Express 12:00',
            '82' => 'UPS Today Standard',
            '83' => 'UPS Today Dedicated Courier',
            '84' => 'UPS Today Intercity',
            '85' => 'UPS Today Express',
            '86' => 'UPS Today Express Saver',
            '96' => 'UPS Worldwide Express Freight',
        ];

        return $services[$serviceCode] ?? 'UPS Service ' . $serviceCode;
    }

    /**
     * Format address (legacy method for backward compatibility)
     */
    private function formatAddress(array $address, bool $isShipper = false): array
    {
        $formatted = [
            'Name' => $address['name'] ?? ($isShipper ? 'Shipper' : 'Recipient'),
            'Address' => [
                'AddressLine' => [$address['address_line']],
                'City' => $address['city'],
                'StateProvinceCode' => $address['state'],
                'PostalCode' => $address['postal_code'],
                'CountryCode' => $address['country_code'] ?? 'US'
            ]
        ];

        if ($isShipper && isset($address['phone'])) {
            $formatted['Phone'] = ['Number' => $address['phone']];
        }

        return $formatted;
    }

    private function validateAddress(array $address, string $type): void
    {
        foreach (['address_line', 'city', 'state', 'postal_code', 'country_code'] as $field) {
            if (empty($address[$field])) {
                throw new Exception("Address $type field '$field' is required.");
            }
        }

        // Validate US state codes if country is US
        if (($address['country_code'] ?? 'US') === 'US') {
            $this->validateUSStateCode($address['state'], $type);
        }
    }

    /**
     * Validate US state code
     */
    private function validateUSStateCode(string $stateCode, string $addressType): void
    {
        $validStates = [
            'AL',
            'AK',
            'AZ',
            'AR',
            'CA',
            'CO',
            'CT',
            'DE',
            'FL',
            'GA',
            'HI',
            'ID',
            'IL',
            'IN',
            'IA',
            'KS',
            'KY',
            'LA',
            'ME',
            'MD',
            'MA',
            'MI',
            'MN',
            'MS',
            'MO',
            'MT',
            'NE',
            'NV',
            'NH',
            'NJ',
            'NM',
            'NY',
            'NC',
            'ND',
            'OH',
            'OK',
            'OR',
            'PA',
            'RI',
            'SC',
            'SD',
            'TN',
            'TX',
            'UT',
            'VT',
            'VA',
            'WA',
            'WV',
            'WI',
            'WY',
            'DC' // Washington DC
        ];

        if (!in_array(strtoupper($stateCode), $validStates)) {
            throw new Exception("Invalid US state code '$stateCode' for $addressType address. Valid codes: " . implode(', ', $validStates));
        }
    }

    private function validatePackageDetails(array $packageDetails): void
    {
        foreach (['weight', 'length', 'width', 'height'] as $field) {
            if (empty($packageDetails[$field])) {
                throw new Exception("Package detail '$field' is required.");
            }
        }
    }
}
