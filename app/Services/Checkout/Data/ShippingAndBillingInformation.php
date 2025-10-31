<?php
namespace App\Services\Checkout\Data;

class ShippingAndBillingInformation
{

   
    public $firstName;
    public $lastName;
    public $email;
    public $address_line;
    public $latitude;
    public $longitude;
    public $city;
    public $state;
    public $state_code;
    public $post_code;
    public $phone;
    public $country_code;
    public $country_name;
    public $state_name;
    
    public function __construct(
  
        string $firstName,
        string $lastName,
        string $email,
        string $address_line,
        string | null $latitude = null,
        string | null $longitude =null,
        string $city,
        string $state,
        string $state_code,
        string $post_code,
        string $phone,
        string $country_code,
        string $country_name,
        string $state_name

    ) {
      
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->address_line = $address_line;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->city = $city;
        $this->state = $state;
        $this->state_code = $state_code;
        $this->post_code = $post_code;
        $this->phone = $phone;
        $this->country_code = $country_code;
        $this->country_name = $country_name;
        $this->state_name = $state_name;
    }


    public function toArray(){
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'address_line' => $this->address_line,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'city' => $this->city,
            'state' => $this->state,
            'state_code' => $this->state_code,
            'post_code' => $this->post_code,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
        ];
    }

    public function toJson(){
        return json_encode($this->toArray());
    }

   
}
