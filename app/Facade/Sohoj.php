<?php

namespace App\Facade;

use App\Models\Setting;
use Cart;
use Voyager;

use App\Models\Shipping;
use App\Setting\Settings;
use Illuminate\Support\Facades\Session;

class Sohoj
{
    public function price($price)
    {
        return "$" . $this->round_num($price);
        // dd($price);
    }
    public function tax()
    {
        return 0;
        $subtotal = Cart::subtotalFloat();
        $total = $subtotal - $this->discount();
        $taxRate = (float) Settings::setting('admin_tax');

        if ($taxRate > 0) {
            return ($taxRate * $total) / 100;
        }
        return 0;
    }

    public function discount()
    {
        if (session()->has('discount')) {
            return session()->get('discount');
        }
        return 0;
    }
    public function discount_code()
    {
        if (session()->has('discount_code')) {
            return session()->get('discount_code');
        }
        return null;
    }
    public function shipping_method()
    {
        if (session()->has('shipping_method')) {
            return session()->get('shipping_method');
        } else {
            $shipping = Shipping::first();
            return $shipping->Shipping_method;
        }
    }
    public function shipping()
    {
        $cart = Cart::content();

        $totalShippingCost = 0;

        foreach ($cart as $item) {
            $shippingCost = $item->model->shipping_cost;
            $totalShippingCost += $shippingCost;
        }

        return $totalShippingCost;
    }
    public function newItemTotal()
    {
        return Cart::subtotalFloat();
    }
    public function newSubtotal()
    {
        $subtotal = Cart::subtotalFloat();
        return ($subtotal + $this->tax() + $this->shipping()) - $this->discount();
    }

    public function newTotal()
    {
        return ($this->newItemTotal() - $this->discount() + $this->shipping());
        // return ($this->newSubtotal() + $this->shipping());
    }
    public function round_num($price)
    {
        return sprintf("%0.2f", $price);
    }
    public function average_rating($ratings)
    {
        if ($ratings->count() > 0) {
            return $ratings->sum('rating') / $ratings->count();
        }
        return 0.00;
    }

    public function flatCommision($price)
    {
        if ($price < 30) {
            return  1.95;
        } elseif ($price > 30 && $price < 300) {
            return  3.75;
        } elseif ($price > 300 && $price < 1000) {
            return  7.95;
        } else {
            return  20;
        }
    }
    public function vendorprice($price)
    {
        // return $price;

        $tenPercent = $price * .06;
        $sixPercent = $price * .06;
        if ($price < 1000) {
            return ($price - $tenPercent);
        } else {
            return ($price - $sixPercent);
        }
    }
    public function vendorCommission()
    {
        return 0.10;
    }


    public function taxCalculation($price)
    {

        $total = $price - $this->discount();
        $taxRate = (float) Settings::setting('admin_tax');

        if ($taxRate > 0) {
            return ($taxRate * $total) / 100;
        }
        return 0;
    }

    public function freeShippingInfo(): array
    {
        $country = strtoupper(Session::get('detected_country', 'US'));
        $subtotal = Cart::subtotal();

        if ($country === 'US' && $subtotal >= 75) {
            return ['eligible' => true, 'message' => 'Free Shipping – Applied!'];
        }

        if ($country === 'US' && $subtotal < 75) {
            $remaining = 75 - $subtotal;
            return [
                'eligible' => false,
                'message' => "Add $" . number_format($remaining, 2) . " more for free U.S. shipping!"
            ];
        }

        return ['eligible' => false, 'message' => null];
    }
}
