<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'rating' => $this->rating,
            'review' => $this->review,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => $this->whenLoaded('product', function () {
                return ProductResource::make($this->product);
            }),
            'shop' => $this->whenLoaded('shop', function () {
                return VendorResource::make($this->shop);
            }),
            'myself' => auth()->guard('sanctum')->check() ? $this->user_id == auth()->guard('sanctum')->user()->id : false,
        ];
    }
}
