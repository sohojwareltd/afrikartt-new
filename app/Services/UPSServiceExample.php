<?php

namespace App\Services;

use App\Services\UPSService;
use Exception;

/**
 * Example usage of UPSService for creating shipments
 * 
 * This class demonstrates how to properly use the UPSService
 * to create shipments according to UPS Ship API v2409 specifications.
 */
class UPSServiceExample
{
    private $upsService;

    public function __construct()
    {
        $this->upsService = new UPSService();
    }

    /**
     * Example: Create a basic ground shipment
     */
    public function createBasicShipment()
    {
        try {
            // Shipper address (your business address)
            $fromAddress = [
                'name' => 'Your Business Name',
                'attention_name' => 'John Doe',
                'address_line' => '123 Business Street',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country_code' => 'US',
                'phone' => '555-123-4567',
                'tax_id' => '12-3456789' // Optional
            ];

            // Recipient address
            $toAddress = [
                'name' => 'Customer Name',
                'attention_name' => 'Jane Smith',
                'address_line' => '456 Customer Avenue',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90210',
                'country_code' => 'US',
                'phone' => '555-987-6543'
            ];

            // Package details
            $packageDetails = [
                'weight' => 2.5, // pounds
                'length' => 12,  // inches
                'width' => 8,    // inches
                'height' => 6,   // inches
                'description' => 'Electronics Package'
            ];

            // Service code (03 = Ground)
            $serviceCode = '03';

            // Create the shipment
            $result = $this->upsService->createShipment(
                $fromAddress,
                $toAddress,
                $packageDetails,
                $serviceCode
            );

            if ($result['success']) {
                echo "Shipment created successfully!\n";
                echo "Tracking Number: " . $result['tracking_number'] . "\n";
                echo "Total Cost: $" . $result['total_cost'] . " " . $result['currency'] . "\n";
                
                // Save the label (base64 encoded)
                if ($result['label']) {
                    $this->saveShippingLabel($result['label'], $result['tracking_number']);
                }
            }

            return $result;

        } catch (Exception $e) {
            echo "Error creating shipment: " . $e->getMessage() . "\n";
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Example: Create an express shipment
     */
    public function createExpressShipment()
    {
        try {
            $fromAddress = [
                'name' => 'Your Business Name',
                'attention_name' => 'John Doe',
                'address_line' => '123 Business Street',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country_code' => 'US',
                'phone' => '555-123-4567'
            ];

            $toAddress = [
                'name' => 'Customer Name',
                'attention_name' => 'Jane Smith',
                'address_line' => '456 Customer Avenue',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90210',
                'country_code' => 'US',
                'phone' => '555-987-6543'
            ];

            $packageDetails = [
                'weight' => 1.0,
                'length' => 10,
                'width' => 8,
                'height' => 4,
                'description' => 'Urgent Document'
            ];

            // Service code (01 = Next Day Air)
            $serviceCode = '01';

            $result = $this->upsService->createShipment(
                $fromAddress,
                $toAddress,
                $packageDetails,
                $serviceCode
            );

            return $result;

        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Example: Get shipping rates before creating shipment
     */
    public function getRatesExample()
    {
        try {
            $fromAddress = [
                'address_line' => '123 Business Street',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country_code' => 'US'
            ];

            $toAddress = [
                'address_line' => '456 Customer Avenue',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90210',
                'country_code' => 'US'
            ];

            $packageDetails = [
                'weight' => 2.5,
                'length' => 12,
                'width' => 8,
                'height' => 6
            ];

            $rates = $this->upsService->getRates($fromAddress, $toAddress, $packageDetails);
            
            echo "Available shipping rates:\n";
            if (isset($rates['RateResponse']['RatedShipment'])) {
                foreach ($rates['RateResponse']['RatedShipment'] as $rate) {
                    echo "Service: " . $rate['Service']['Description'] . "\n";
                    echo "Code: " . $rate['Service']['Code'] . "\n";
                    echo "Total Cost: $" . $rate['TotalCharges']['MonetaryValue'] . "\n";
                    echo "---\n";
                }
            }

            return $rates;

        } catch (Exception $e) {
            echo "Error getting rates: " . $e->getMessage() . "\n";
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Example: Track a shipment
     */
    public function trackShipmentExample($trackingNumber)
    {
        try {
            $trackingInfo = $this->upsService->trackShipment($trackingNumber);
            
            echo "Tracking Information for: " . $trackingNumber . "\n";
            if (isset($trackingInfo['TrackResponse']['Shipment'])) {
                $shipment = $trackingInfo['TrackResponse']['Shipment'];
                echo "Status: " . $shipment['Package']['Activity'][0]['Status']['Description'] . "\n";
                echo "Location: " . $shipment['Package']['Activity'][0]['ActivityLocation']['Address']['City'] . "\n";
            }

            return $trackingInfo;

        } catch (Exception $e) {
            echo "Error tracking shipment: " . $e->getMessage() . "\n";
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Save shipping label to file
     */
    private function saveShippingLabel($base64Label, $trackingNumber)
    {
        try {
            $labelData = base64_decode($base64Label);
            $filename = storage_path('app/shipping_labels/' . $trackingNumber . '.gif');
            
            // Create directory if it doesn't exist
            $directory = dirname($filename);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            
            file_put_contents($filename, $labelData);
            echo "Shipping label saved to: " . $filename . "\n";
            
        } catch (Exception $e) {
            echo "Error saving label: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Common UPS service codes
     */
    public function getServiceCodes()
    {
        return [
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
    }
}