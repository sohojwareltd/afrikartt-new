<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VendorApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::active();

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->whereHas('products', function ($query) use ($request) {
                $query->whereHas('prodcats', function ($query) use ($request) {
                    $query->where('slug', $request->category);
                });
            });
        }

        // Filter by location (post_city)
        if ($request->filled('post_city')) {
            $query->where(function ($q) use ($request) {
                $q->where('post_code', 'like', '%' . $request->post_city . '%')
                  ->orWhere('city', 'like', '%' . $request->post_city . '%');
            });
        }

        // Filter by state
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        // Filter by liked shops (if user is authenticated)
        if ($request->filled('type') && $request->type === 'liked' && \Illuminate\Support\Facades\Auth::check()) {
            $query = Shop::whereIn('id', \Illuminate\Support\Facades\Auth::user()->followedShops->pluck('id'))->active();
        }

        // Load products count
        $query->withCount('products');

        // Paginate results
        $vendors = $query->paginate($request->get('per_page', 12));

        return VendorResource::collection($vendors);
    }

    public function show(Shop $shop)
    {
        $vendor = Shop::where('slug', $shop->slug)
            ->with(['ratings'])
            ->where('status', 1)
            ->with(['products' => function ($query) {
                $query->whereNull('parent_id');
            }])
            ->firstOrFail();

        return new VendorResource($vendor);
    }
} 