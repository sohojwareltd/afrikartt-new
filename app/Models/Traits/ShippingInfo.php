<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait ShippingInfo
{
    public function contains_battery_pi966()
    {
        return boolval($this->parcels[0]['contains_battery_pi966'] ?? false);
    }

    public function contains_battery_pi967()
    {
        return boolval($this->parcels[0]['contains_battery_pi967'] ?? false);
    }

    public function contains_liquids()
    {
        return boolval($this->parcels[0]['contains_liquids'] ?? false);
    }

    public function origin_country_alpha2()
    {
        return strtoupper($this->parcels[0]['origin_country_alpha2'] ?? '');
    }

    public function length()
    {
        return number_format($this->parcels[0]['length'] ?? 25, 2);
    }

    public function width()
    {
        return number_format($this->parcels[0]['width'] ?? 25, 2);
    }

    public function height()
    {
        return number_format($this->parcels[0]['height'] ?? 25, 2);
    }

    public function weight(){
        return number_format($this->parcels[0]['actual_weight'] ?? 0.5, 2);
    }

    public function hs_code(){
        return $this->parcels[0]['category_id'] ?? null;
    }

    public function category_id(){
        return (string) $this->parcels[0]['category_id'] ?? null;
    }

    public function description(){
        return $this->parcels[0]['description'] ?? '';
    }
    
}
