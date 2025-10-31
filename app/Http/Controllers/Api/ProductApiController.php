<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RatingResource;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Shop;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $products = ProductRepository::getAllProducts(20);
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load('ratings');

        return ProductResource::make($product);
    }

    public function vendorProducts(Shop $shop, Request $request)
    {
        $products = ProductRepository::getVendorProducts($shop, $request->all());
        return ProductResource::collection($products);
    }
    public function submitRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->product_id);
        $user = Auth::guard('sanctum')->user();
        $rating = Rating::updateOrCreate([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ], [
            'name' => $user->name,
            'email' => $user->email,
            'rating' => intval($request->rating),
            'review' => $request->review,
            'product_id' => $product->id,
            'user_id' => $user->id,
            'shop_id' => $product->shop_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thanks for your review',
            'data' => RatingResource::make($rating)
        ]);
    }

    public function myRatings()
    {
        $user = Auth::guard('sanctum')->user();
        $ratings = Rating::where('user_id', $user->id)->with(['product', 'shop'])->latest()->paginate(10);
        return RatingResource::collection($ratings);
    }

    public function ratings(Product $product)
    {
        $ratings = Rating::where('product_id', $product->id)->with(['user', 'shop'])->latest()->paginate(10);
        return RatingResource::collection($ratings);
    }
}
