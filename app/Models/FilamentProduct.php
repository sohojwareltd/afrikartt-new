<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentProduct extends Model
{

    protected $table = 'products';
    protected $guarded = [];
    protected $casts = [
        'images' => 'array',
        'variations' => 'array',
        'parcels' => 'array',
    ];
    public function getParcelsAttribute($value)
    {
    
        if (is_array($value)) {
            $parcels = $value;
        }
        elseif (is_string($value) && !empty($value)) {
            $parcels = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE || $parcels === null) {
                $parcels = [];
            }
        }
        else {
            $parcels = [];
        }

        return collect($parcels)->map(function ($parcel) {
        
            if (!is_array($parcel)) {
                return [
                    'length' => null,
                    'width' => null,
                    'height' => null,
                    'actual_weight' => null,
                    'contains_battery_pi966' => false,
                    'contains_battery_pi967' => false,
                    'contains_liquids' => false,
                    'category_id' => null,
                    'description' => '',
                    'origin_country_alpha2' => '',
                ];
            }

            return [
                'length' => isset($parcel['length']) ? (int) $parcel['length'] : null,
                'width' => isset($parcel['width']) ? (int) $parcel['width'] : null,
                'height' => isset($parcel['height']) ? (int) $parcel['height'] : null,
                'actual_weight' => isset($parcel['actual_weight']) ? (float) $parcel['actual_weight'] : null,
                'contains_battery_pi966' => isset($parcel['contains_battery_pi966']) ? (bool) $parcel['contains_battery_pi966'] : false,
                'contains_battery_pi967' => isset($parcel['contains_battery_pi967']) ? (bool) $parcel['contains_battery_pi967'] : false,
                'contains_liquids' => isset($parcel['contains_liquids']) ? (bool) $parcel['contains_liquids'] : false,
                'category_id' => $parcel['category_id'] ?? null,
                'description' => $parcel['description'] ?? '',
                'origin_country_alpha2' => $parcel['origin_country_alpha2'] ?? '',
            ];
        })->toArray();
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function discount()
    {
        $discount_amount  = $this->price - $this->sale_price;
        $discount_percantage = ($discount_amount / $this->price) * 100;
        return round($discount_percantage);
    }
    public function prodcats()
    {
        return $this->belongsToMany(Prodcat::class, 'prodcat_product', 'product_id', 'prodcat_id', 'id', 'id')->withTimestamps();
    }
    public function parentproduct()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }
    public function path()
    {
        return route('product', $this->slug);
    }
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
    public function subproducts()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }
    public function subproductsuser()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id')->where('price', '>', 0)->whereNotNull('variations');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class)->where('status', 1)->latest();
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getImagesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }





    public function getPrice()
    {
        return $this->sale_price ?? $this->price;
    }
}
