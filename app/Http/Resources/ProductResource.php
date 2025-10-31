<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'image'         => Storage::url($this->image),
            'images'        => array_map(function ($image) {
                return Storage::url($image);
            }, $this->images),
            'price'         => $this->sale_price ?? $this->price,
            'compare_at_price' => $this->sale_price ? $this->price : null,
            'shop'          => VendorResource::make($this->shop),
            'categories'    => CategoryResource::collection($this->prodcats),
            'description'   => $this->description,
            'short_description' => $this->short_description,
            'views'         => $this->views,
            'is_variable_product' => $this->is_variable_product,
            'variations'    => $this->is_variable_product ?  (collect($this->variations)->map(function ($variation) {
                $data = $variation->toArray();
                $data['variant_image'] = Storage::url($data['variant_image']);
                return $data;
            })) : null,
            'average_rating' => $this->ratings->avg('rating'),
            'rating_count' => $this->ratings->count(),
            'ratings' => $this->whenLoaded('ratings', function () {
                return RatingResource::collection($this->ratings);
            }),
            'start_from'    => $this->is_variable_product ? collect($this->variations)->min('price') : $this->price,
            'is_wishlisted' =>  $this->wishlistedBy()->where('user_id', auth()->guard('sanctum')->id())->exists(),
        ];
    }
}
