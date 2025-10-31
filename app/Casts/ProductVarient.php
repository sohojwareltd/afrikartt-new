<?php

namespace App\Casts;

use App\Casts\ProductVarient\Varient;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProductVarient implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (empty($value)) {
            return [];
        }
        
        $decoded = json_decode($value, true);
        if (!is_array($decoded)) {
            return [];
        }
        
        return array_map(function($variation, $index) use ($model) {
            return new Varient($variation, $model, $index);
        }, $decoded, array_keys($decoded));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_array($value)) {
            // Convert Varient objects back to arrays if needed
            $processed = array_map(function($item) {
                if ($item instanceof Varient) {
                    return $item->toArray();
                }
                return $item;
            }, $value);
            return json_encode($processed);
        }
        return $value;
    }
}
