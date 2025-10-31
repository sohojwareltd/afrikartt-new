<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VendorResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wishlist = $user->wishlist()->paginate(10); 
        return ProductResource::collection($wishlist);
    }


    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();

        if ($user->wishlist()->where('product_id', $request->product_id)->exists()) {
            $user->wishlist()->detach($request->product_id);
            return response()->json(['message' => 'Product removed from wishlist']);
        } else {
            $user->wishlist()->attach($request->product_id);
            return response()->json(['message' => 'Product added to wishlist']);
        }
    }

    public function followToggle(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
        ]);

        $user = Auth::user();
        
        if ($user->followedShops()->where('shop_id', $request->shop_id)->exists()) {
            $user->followedShops()->detach($request->shop_id);
            return response()->json(['message' => 'Shop unfollowed']);
        } else {
            $user->followedShops()->attach($request->shop_id);
            return response()->json(['message' => 'Shop followed']);
        }
    }
    public function followedShops()
    {
        $user = Auth::user();
        $followedShops = $user->followedShops()->paginate(10);
        return VendorResource::collection($followedShops);
    }

   
}
