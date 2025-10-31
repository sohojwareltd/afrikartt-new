<?php

namespace App\Services\Checkout\Data;

use App\Data\Country\CountryStateCity;

class ShippingAndBillingInformationApi
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
    public $country;

    public function __construct(

        string $firstName,
        string $lastName,
        string $email,
        string $address_line,
        string $city,
        string $state,
        string $post_code,
        string $phone,
        string $country,

    ) {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->address_line = $address_line;
        $this->city = $city;
        $this->state = $state;
        $this->post_code = $post_code;
        $this->phone = $phone;
        $this->country = $country;

        $this->country_code = $this->countryDetails($country)['iso2'];
        $this->country_name = $this->countryDetails($country)['name'];
        $this->state_code = $this->stateDetails($this->countryDetails($country)['id'], $state)['iso2'];
        $this->state_name = $this->stateDetails($this->countryDetails($country)['id'], $state)['name'];
    }


    public function toArray()
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'address_line' => $this->address_line,
            'city' => $this->city,
            'state' => $this->state,
            'post_code' => $this->post_code,
            'phone' => $this->phone,
            'country' => $this->country,
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    private function countryDetails($country)
    {
        $geo = new CountryStateCity();
        $countries = (new CountryStateCity())->countries();
        $countryId =  array_search($country, $countries->toArray());

        return $geo->countryDetails($countryId);
    }

    private function stateDetails($country, $state)
    {
        $geo = new CountryStateCity();
        $states = (new CountryStateCity())->states($country);
        $stateId =  array_search($state, $states->toArray());
        return $geo->stateDetails($country, $stateId);
    }

    public function createShippingAndBillingInformation()
    {
        $shippingAndBillingInformation = new ShippingAndBillingInformation(
            firstName: $this->firstName,
            lastName: $this->lastName,
            email: $this->email,
            address_line: $this->address_line,
            latitude: null,
            longitude: null,
            city: $this->city,
            state: $this->state,
            state_code: $this->state_code,
            state_name: $this->state_name,
            post_code: $this->post_code,
            phone: $this->phone,
            country_code: $this->country_code,
            country_name: $this->country_name

        );
        return $shippingAndBillingInformation;
    }
}
