<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Http\Request;
use Cart;
use App\Models\Product;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
	public function add(Request $request)
	{
		$this->cart($request);
		$this->validateCoupon();
		return redirect()->back()->with('success_msg', 'Item has been added to cart!');
		// return response()->json(['success' => 'Item has been added to cart']);
	}
	// public function update(Request $request)
	// {

	// 	Cart::update($request->product_id, array(
	// 		'quantity' => array(
	// 			'relative' => false,
	// 			'value' => $request->quantity
	// 		),
	// 	));
	// 	return back()->with('success_msg', 'Item has been updated!');
	// }

	// public function update(Request $request)
	// {
	// 	$request->validate([
	// 		'rowId' => 'required',
	// 		'quantity' => 'required|integer|min:1',
	// 	]);
	// 	Cart::update($request->rowId, [
	// 		'qty' => $request->quantity // You can also use 'quantity' => $value but qty is preferred
	// 	]);

	// 	return back()->with('success_msg', 'Item has been updated!');
	// }


	public function update(Request $request)
	{
		$rowId = $request->input('rowId');
		$qty = $request->input('qty');

		if ($request->action == 'increase') {
			Cart::update($rowId, $qty + 1);
		} elseif ($request->action == 'decrease' && $qty > 1) {
			Cart::update($rowId, $qty - 1);
		} else {
			return back()->with('success_msg', 'Quantity cannot be less than 1!');
		}

		$this->validateCoupon();

		return back()->with('success_msg', 'Item has been updated!');
	}



	public function destroy($rowId)
	{
		Cart::remove($rowId);
		$this->validateCoupon();

		return back()->with('success_msg', 'Item has been removed!');
	}

	public function offerToCart(Request $request)
	{

		$product = Product::find(request('product_id'));
		$offer = Offer::find(request('offer'));
		if ($offer->is_offer == 1) {

			// if ($product->sale_price) {
			// 	$price = ($product->sale_price - $request->offer_price);
			// } else {
			// 	$price = ($product->price - $request->offer_price);
			// }
			$price = request('offer_price');
			Cart::add($product->id, $product->name, $price, request('quantity'), 'is_offer')->associate('App\Models\Product');

			$offer->update([
				'is_offer' => 0,
			]);
			//session()->flash('errors', collect(['Please Check Length,Width,Height,Weight again of this product']));
			return redirect()->route('cart')->with('success_msg', 'Item has been added to cart!');
		} else {
			return redirect(env('APP_URL') . '/product/' . $product->slug)->withErrors('Sorry! Please again Offer send');
		}
	}
	public function cartQty()
	{
		$cartqty = Cart::count();

		return response()->json($cartqty);
	}

	public function buynow(Request $request)
	{
		$this->cart($request);

		// Handle different buy intents
		if (isset($request->add_to_cart)) {
			return redirect()->back()->with('success_msg', 'Item has been added to cart!');
		}

		// If coming from guest modal, go to cart page
		if ($request->input('buy_intent') === 'buy_now_guest') {
			return redirect('/cart')->with('success_msg', 'Item has been added to cart!');
		}

		// If coming from sign in/sign up modal, add to cart and redirect to auth
		if ($request->input('buy_intent') === 'buy_now_signin') {
			return redirect()->route('login', ['redirect' => url('/cart')])->with('success_msg', 'Item has been added to cart! Please sign in to continue.');
		}

		if ($request->input('buy_intent') === 'buy_now_signup') {
			return redirect()->route('register', ['redirect' => url('/cart')])->with('success_msg', 'Item has been added to cart! Please sign up to continue.');
		}

		// For logged-in users, Buy Now should go to cart page
		if ($request->input('buy_intent') === 'buy_now') {
			return redirect('/cart')->with('success_msg', 'Item has been added to cart!');
		}

		// Default fallback
		return redirect('/checkout')->with('success_msg', 'Item has been added to cart!');
	}

	private function cart($request)
	{
		$variation = null;

		if ($request->filled('selected_variant_sku')) {
			$variation = Product::find($request->product_id)->getVariationBySku($request->selected_variant_sku);
		}

		$product = Product::find($request->product_id);
		$price = $variation ? $variation->price : $product->getPrice();

		if ($price == false) {
			return response()->json(['error' => 'price not available'], 404);
		}

		Cart::add([
			'id'      => $product->id,
			'name'    => $product->name,
			'price'   => $price,
			'qty'     => $request->quantity,
			'weight'  => 0,
			'options' => [
				'offer'     => 'no_offer',
				'variation' => $variation ? $variation->getSku() : null,
			]
		])->associate('App\Models\Product');



		return response()->json(['success' => 'Product added to cart']);
	}
	public function validateCoupon()
	{
		if (!Session::has('coupon_id')) {
			return;
		}

		$coupon = Coupon::find(Session::get('coupon_id'));

		if (!$coupon || Cart::subTotal() < $coupon->minimum_cart) {

			Session::forget('discount');
			Session::forget('discount_code');
			Session::forget('coupon_id');

			session()->flash('errors', collect(['Coupon removed - cart no longer meets requirements']));
		} else {

			$discount = (Cart::subTotal() * $coupon->discount) / 100;
			Session::put('discount', $discount);
		}
	}


	// private function cart($request)
	// {
	// 	if ($request->variable_attribute) {
	// 		$variation = json_encode($request->variable_attribute);
	// 		$product = DB::table('products')
	// 			->where('parent_id', $request->product_id)
	// 			->whereRaw("JSON_CONTAINS(variations, ?)", [$variation])
	// 			->first();

	// 		if (!$product) {
	// 			return response()->json(['error' => 'Sorry! This variation is no longer available'], 404);
	// 		}
	// 	} else {
	// 		$product = Product::find($request->product_id);
	// 	}

	// 	$price = $product->sale_price ?: $product->price;

	// 	Cart::add([
	// 		'id'      => $product->id,
	// 		'name'    => $product->name,
	// 		'qty'     => $request->quantity,
	// 		'price'   => $price,
	// 		'weight'  => 0,
	// 		'options' => [
	// 			'offer' => 'no_offer',
	// 			'variation' => $request->variable_attribute ?? null,
	// 		]
	// 	])->associate(Product::class);


	// }
}
