<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
	public function add(Request $request)
	{
		$coupon = Coupon::where('code', $request->coupon_code)->first();

		if (!$coupon) {
			session()->flash('errors', collect(['Incorrect coupon code']));
			return back();
		}

		// Validate coupon conditions
		if (Carbon::create($coupon->expire_at) < now()) {
			session()->flash('errors', collect(['Coupon has been expired']));
			return back();
		}
		if ($coupon->limit <= $coupon->used) {
			session()->flash('errors', collect(['Coupon has been expired']));
			return back();
		}
		if (Cart::subTotal() < $coupon->minimum_cart) {
			session()->flash('errors', collect(['Minimum cart required to use this coupon ' . $coupon->minimum_cart]));
			return back();
		}
		if (Carbon::create($coupon->start_at) > now()) {
			session()->flash('errors', collect(['Coupon is not active yet']));
			return back();
		}

		$discount = (Cart::subTotal() * $coupon->discount) / 100;
		Session::put('discount', $discount);
		Session::put('discount_code', $coupon->code);
		Session::put('coupon_id', $coupon->id);

		return back()->with('success_msg', 'Coupon has been applied successfully');
	}

	public function destroy()
	{
		session()->forget('discount');
		session()->forget('discount_code');
		session()->forget('coupon_id');
		return back()->with('success_msg', 'Coupon removed successfully');
	}
}
