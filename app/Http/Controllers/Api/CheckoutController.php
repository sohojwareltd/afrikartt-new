<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Data\Country\CountryStateCity;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\StateRate;
use App\Services\Checkout\CheckoutService;
use App\Services\Checkout\Data\ShippingAndBillingInformationApi;
use Error;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        Cart::destroy();
        $validator = Validator::make($request->all(), [
            'first_name'             => 'required',
            'last_name'              => 'required',
            'email'                  => 'required|email',
            'address_1'              => 'required',
            'city'                   => 'required',
            'state'                  => 'required',
            'post_code'              => 'required',
            'phone'                  => 'required',
            'country'                => 'required',
            'products'               => 'required|array',
            'products.*.id'          => 'required|exists:products,id',
            'products.*.quantity'    => 'required|integer|min:1',
            'products.*.variant_sku' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $validator->validated();

        
            $this->createCart($request->products);

            $shippingAndBillingInformation = [
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'email' => $request->email,
                'address_line' => $request->address_1,
                'city' => $request->city,
                'state' => $request->state,
                'post_code' => $request->post_code,
                'phone' => $request->phone,
                'country_code' => $request->country,
            ];




            $checkoutService = new CheckoutService($shippingAndBillingInformation);
            $order           = $checkoutService->createOrder();

            return $order;

            return response()->json(['message' => 'Shipping and billing information stored successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception  | Error $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function createCart(array $products)
    {

        foreach ($products as $data) {
            $variation = null;
            if (isset($data['variant_sku'])) {
                $variation = Product::find($data['id'])->getVariationBySku($data['variant_sku']);
            }

            $product = Product::find($data['id']);

            $price = $variation ? $variation->price : $product->getPrice();

            Cart::add([
                'id'      => $product->id,
                'name'    => $product->name,
                'price'   => $price,
                'qty'     => $data['quantity'],
                'weight'  => 0,
                'options' => [
                    'offer'     => 'no_offer',
                    'variation' => $variation ? $variation->getSku() : null,
                ],
            ])->associate('App\Models\Product');
        }
    }

    public function countries()
    {
        $countries = Country::where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        $formatted = [];

        foreach ($countries as $country) {
            $formatted[$country->id] = $country->name;
        }

        return response()->json($formatted);
    }

    public function resolveCountry(Request $request)
    {
        $needle = $request->query('needle');
        if (!$needle) {
            return response()->json(['error' => 'needle parameter required'], 400);
        }

        $country = Country::where('status', 1)
            ->where(function ($q) use ($needle) {
                $q->where('code', 'like', $needle . '%')
                    ->orWhere('name', 'like', '%' . $needle . '%');
            })
            ->first(['id', 'name', 'code']);

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        return response()->json([
            'id' => $country->id,
            'name' => $country->name,
            'code' => $country->code,
        ]);
    }

    public function states($countryId)
    {
        $states = StateRate::where('country_id', $countryId)
            ->where('status', 1)
            ->orderBy('state', 'asc')
            ->get(['id', 'state']);

        $formatted = [];

        foreach ($states as $state) {
            $formatted[$state->id] = $state->state;
        }

        return response()->json($formatted);
    }

    public function cities($country, $state)
    {
        $data = (new CountryStateCity())->cities($country, $state);
        return response()->json($data);
    }
    public function CouponDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subtotal' => 'required|numeric|min:0',
            'coupon' => 'required|string|exists:coupons,code',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = Coupon::where('code', $request->coupon)->first();

        if (!$data) {
            return response()->json(['error' => 'Coupon not found'], 404);
        }

        if (Carbon::parse($data->expire_at)->isPast()) {
            return response()->json(['error' => 'Coupon has expired'], 400);
        }

        if (Carbon::parse($data->start_at)->isFuture()) {
            return response()->json(['error' => 'Coupon is not active yet'], 400);
        }

        if ($data->limit <= $data->used) {
            return response()->json(['error' => 'Coupon has reached its usage limit'], 400);
        }

        if ($request->subtotal < $data->minimum_cart) {
            return response()->json(['error' => 'Minimum cart value required to use this coupon'], 400);
        }


        return response()->json([
            'discount_percentage' => $data->discount,
            'code' => $data->code,

        ], 200);
    }

    public function shippingRates(Request $request)
    {
        $country = $request->query('country');

        $query = Shipping::query();

        // Filter by country name or country code if provided
        if ($country) {
            $query->where(function ($q) use ($country) {
                $q->where('country_name', $country)
                    ->orWhere('country_code', $country);
            });
        }

        $shippingRates = $query->orderBy('country_name', 'asc')
            ->get()
            ->map(function ($shipping) {
                return [
                    'id' => $shipping->id,
                    'country_code' => $shipping->country_code,
                    'country_name' => $shipping->country_name,
                    'price' => (float) $shipping->price,
                    'is_default' => (bool) $shipping->default,
                ];
            });

        return response()->json([
            'success' => true,
            'country' => $country,
            'rates' => $shippingRates
        ]);
    }
}