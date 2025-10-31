<?php

namespace App\Data\Country;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Africa
{
    public Collection $data;
    public function __construct()
    { 
        $countries = json_decode(File::get(public_path('africa.json')), true);
        $this->data = collect($countries)->map(function($country){
            return [
                'name' => $country['name'],
                'flag' => $country['flags']['png'],
            ];
        });
    }
    
    public static function getCountries($key = null)
    {
        return (new self())->data;
    }

    public static function getCountry($key)
    {
        return (new self())->data->where('name', $key)->first();
    }
}
