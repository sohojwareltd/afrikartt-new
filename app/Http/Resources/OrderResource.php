<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'shop_id'               => $this->shop_id,
            'status'                => $this->status,
            'status_text'           => $this->getStatusText(),
            'currency'              => $this->currency,
            'discount'              => $this->discount,
            'discount_code'         => $this->discount_code,
            'shipping_total'        => $this->shipping_total,
            'shipping_method'       => $this->shipping_method,
            'shipping_url'          => $this->shipping_url,
            'subtotal'              => $this->subtotal,
            'total'                 => $this->total,
            'vendor_total'          => $this->vendor_total,
            'seen'                  => $this->seen,
            'tax'                   => $this->tax,
            'customer_note'         => $this->customer_note,
            'billing'               => $this->billing ? json_decode($this->billing, true) : null,
            'shipping'              => $this->shipping ? json_decode($this->shipping, true) : null,
            'payment_method'        => $this->payment_method,
            'payment_method_title'  => $this->payment_method_title,
            'transaction_id'        => $this->transaction_id,
            'date_paid'             => $this->date_paid,
            'date_completed'        => $this->date_completed,
            'refund_amount'         => $this->refund_amount,
            'company'               => $this->company,
            'aptment'               => $this->aptment,
            'quantity'              => $this->quantity,
            'order_accept'          => $this->order_accept,
            'parent_id'             => $this->parent_id,
            'products'              => $this->products->map(function ($product) {
                return [
                    'id'            => $product->id,
                    'name'          => $product->name,
                    'sku'           => $product->pivot->sku,
                    'quantity'      => $product->pivot->quantity,
                    'unit_price'         => $product->pivot->price,
                    'total'         => $product->pivot->total_price,
                    'variation'     => $product->pivot->variation ? json_decode($product->pivot->variation, true) : null,
                    'image'         => $product->image ? asset('storage/' . $product->image) : null,
                ];
            }),
            'shop'                  => VendorResource::make($this->whenLoaded('shop')),
            'user'                  => $this->whenLoaded('user'),
            'feedback'              => $this->whenLoaded('feedback'),
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }

    private function getStatusText()
    {
        $statusMap = [
            0 => 'pending',
            1 => 'paid',
            2 => 'on_its_way',
            3 => 'cancelled',
            4 => 'delivered'
        ];

        return $statusMap[$this->status] ?? 'unknown';
    }
}
