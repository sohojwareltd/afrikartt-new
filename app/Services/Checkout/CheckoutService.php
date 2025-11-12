<?php

namespace App\Services\Checkout;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Shop;
use App\Models\User;
use App\Services\Checkout\Data\ShippingAndBillingInformation;
use Exception;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Sohoj;

class CheckoutService
{
    public Cart $cart;
    public ShippingAndBillingInformation $address;
    public  $customer;
    public float $cartSubtotal;
    public float $platformFee;
    public float $discount;
    public float $total;
    public string | null $discountCode;
    public float $tax;
    public function __construct(
        ShippingAndBillingInformation $shippingAndBillingInformation,



    ) {
        
        $this->address = $shippingAndBillingInformation;

        $this->cart = new Cart();
       
        if(Auth::check()){ 
            $this->customer = Auth::user();
        }elseif(Auth::guard('sanctum')->check()){
            $this->customer = Auth::guard('sanctum')->user();
        }
        else{
            $this->customer = null;
        }

        $this->setSubtotal();
        $this->setPlatformFee();
        $this->setDiscount();
        $this->setDiscountCode();
        $this->setTotal();
        $this->setTax();
    }

    private function setSubtotal()
    {
        $this->cartSubtotal = $this->cart::subtotalFloat();
    }

    private function setPlatformFee()
    {
        $this->platformFee = Sohoj::flatCommision($this->cartSubtotal);
    }



    private function setDiscount()
    {
        $this->discount = Sohoj::discount();
    }


    private function setDiscountCode()
    {
        $this->discountCode = Sohoj::discount_code();
    }

    private function setTotal()
    {
        $this->total = $this->cartSubtotal ;
    }


    private function setTax()
    {
        $this->tax = $this->total * 0.1;
    }

    public function createOrder()
    {
        $this->productHasStock();

        $order = Order::create([
            'user_id' =>  $this->customer ? $this->customer->id : null,
            'shop_id' => null,
            'product_id' => null,
            'shipping' => $this->address->toJson(),
            'subtotal' => $this->cartSubtotal,
            'discount' => $this->discount,
            'discount_code' => $this->discountCode,
            'tax' => $this->tax,
            'platform_fee' => $this->platformFee,
            'total' => $this->total,
        ]);

        $groupProductsByShop = $this->cart::content()->groupBy(function ($item) {
            return $item->model->shop_id;
        });

        foreach ($groupProductsByShop as $shopId => $items) {
            $shop = Shop::find($shopId);
            $vendor_price = $items->sum(function ($item) {
                if ($item->model->vendor_price) {
                    return $item->model->vendor_price * $item->qty;
                }
                return ($item->model->price * (90 / 100)) * $item->qty;
            });
            $total_price = $items->sum(function ($item) {
                return $item->price * $item->qty;
            });
            $flat_commision = $total_price - $vendor_price;
            $shopOrder = Order::create([
                'user_id' => $this->customer ? $this->customer->id : null,
                'parent_id' => $order->id,
                'shop_id' => $shop->id,
                'shipping' => $this->address->toJson(),
                'subtotal' => $total_price,
                'platform_fee' => $flat_commision,
                'total' => $total_price,
                'quantity' => $items->sum(function ($item) {
                    return $item->qty;
                }),
                'vendor_total' => $vendor_price,
                'payment_method' => null,



            ]);
            foreach ($items as $item) {
                $sku = null;
                $variationData = null;
                
                // Get SKU from cart options
                if (isset($item->options['sku_id']) && $item->options['sku_id']) {
                    $sku = Sku::with('attributeValues.attribute')->find($item->options['sku_id']);
                    
                    if ($sku) {
                        // Build variation data from SKU
                        $variationData = [
                            'sku_id' => $sku->id,
                            'sku_code' => $sku->sku,
                            'title' => $sku->title,
                            'attributes' => $sku->attributeValues->map(function ($attrValue) {
                                return [
                                    'attribute' => $attrValue->attribute->name ?? 'Unknown',
                                    'value' => $attrValue->getDisplayName(),
                                    'type' => $attrValue->type,
                                ];
                            })->toArray(),
                        ];
                    }
                }
                
                $shopOrder->products()->attach($item->model->id, [
                    'shop_id' => $shop->id,
                    'quantity' => $item->qty,
                    'product_id' => $item->model->id,
                    'sku_id' => $sku ? $sku->id : null,
                    'price' => $item->price,
                    'total_price' => $item->price * $item->qty,
                    'variation' => $variationData ? json_encode($variationData) : null,
                ]);
            }
        }

        foreach ($this->cart::content() as $item) {
            $sku = null;
            $variationData = null;
            
            // Get SKU from cart options
            if (isset($item->options['sku_id']) && $item->options['sku_id']) {
                $sku = Sku::with('attributeValues.attribute')->find($item->options['sku_id']);
                
                if ($sku) {
                    // Build variation data from SKU
                    $variationData = [
                        'sku_id' => $sku->id,
                        'sku_code' => $sku->sku,
                        'title' => $sku->title,
                        'attributes' => $sku->attributeValues->map(function ($attrValue) {
                            return [
                                'attribute' => $attrValue->attribute->name ?? 'Unknown',
                                'value' => $attrValue->getDisplayName(),
                                'type' => $attrValue->type,
                            ];
                        })->toArray(),
                    ];
                }
            }
            
            $order->products()->attach($item->model->id, [
                'shop_id' => $item->model->shop_id,
                'quantity' => $item->qty,
                'product_id' => $item->model->id,
                'sku_id' => $sku ? $sku->id : null,
                'price' => $item->price,
                'total_price' => $item->price * $item->qty,
                'variation' => $variationData ? json_encode($variationData) : null,
            ]);
        }


       

        return $order;
    }


    private function productHasStock()
    {
        foreach (Cart::Content() as $item) {
            // Check SKU stock if item has SKU
            if (isset($item->options['sku_id']) && $item->options['sku_id']) {
                $sku = Sku::find($item->options['sku_id']);
                if ($sku) {
                    if ($sku->quantity < $item->qty) {
                        throw new Exception('Variation "' . ($sku->title ?? $sku->sku) . '" of product "' . $item->model->name . '" has only ' . $sku->quantity . ' in stock');
                    }
                    continue;
                }
            }
            
            // Fallback to product stock for non-variable products
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->qty) {
                throw new Exception('Product ' . $product->name . ' has only ' . $product->quantity . ' in stock');
            }
        }
        return true;
    }
}
