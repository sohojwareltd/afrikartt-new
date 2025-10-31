<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\VendorApiController;
use App\Http\Controllers\Api\CheckoutController as ApiCheckoutController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\WishlistController;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Services\Shipping\EashShipProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('stats', function () {
        $user = Auth::guard('sanctum')->user();
        return response()->json([
            'orders' => $user->orders()->count(),
            'wishlist' => $user->wishlist()->count(),
            'reviews' => $user->ratings()->count(),
        ]);
    });
    //user Dashboard routes
    Route::post('user/profile-update', [UserApiController::class, 'profileUpdate']);
    Route::post('user/password-update', [UserApiController::class, 'updatePassword']);

    Route::post('follow/toggle', [WishlistController::class, 'followToggle']);
    Route::get('followed-shops', [WishlistController::class, 'followedShops']);
    Route::delete('order/delete', [OrderApiController::class, 'deleteOrder']);
    Route::get('orders', [OrderApiController::class, 'userOrders']);
    Route::get('orders/{order}/invoice', [OrderApiController::class, 'downloadInvoice']);
    Route::get('orders/{order}', [OrderApiController::class, 'userOrderDetails']);
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
    Route::post('products/rating', [ProductApiController::class, 'submitRating']);
    Route::get('my-ratings', [ProductApiController::class, 'myRatings']);
});

Route::get('sliders', [SliderApiController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{product}', [ProductApiController::class, 'show']);
Route::get('/products/{product}/ratings', [ProductApiController::class, 'ratings']);
Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/vendors', [VendorApiController::class, 'index']);
Route::get('/vendors/{shop}', [VendorApiController::class, 'show']);
Route::get('vendors/{shop}/products', [ProductApiController::class, 'vendorProducts']);
Route::post('order/checkout', CheckoutController::class);
Route::get('coupon', [ApiCheckoutController::class, 'CouponDetails']);
Route::get('header-announcements', [AuthController::class, 'headerAnnouncements']);

// Country / State / City endpoints
Route::get('geo/countries', [ApiCheckoutController::class, 'countries']);
Route::get('geo/states/{country}', [ApiCheckoutController::class, 'states']);
Route::get('geo/cities/{country}/{state}', [ApiCheckoutController::class, 'cities']);

Route::get('order/{order}/shipping-rates', [OrderApiController::class, 'getShippingRates']);
Route::post('order/{order}/confirm', [OrderApiController::class, 'confirmOrder']);

Route::get('eash-ship', function () {
    $eashShip = new EashShipProvider();
    $rates = $eashShip->getCategories();
    return $rates;
});

Route::get('/test-header', function (Request $request) {
    return response()->json([
        'auth_header' => $request->header('Authorization'),
    ]);
});
