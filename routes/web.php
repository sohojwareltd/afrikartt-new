<?php

use App\Data\Country\Africa;
use App\Data\Country\CountryStateCity;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VendorRegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MassageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PayoutsController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\EmailVerified;
use App\Mail\OfferEmail;
use App\Mail\OrderPlaced;
use App\Mail\ShopCreatedEmail;
use App\Mail\TicketPlaced;
use App\Mail\VerifyEmail;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Page;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\Shipping\EashShipProvider;
use App\Services\UPSService;
use App\Setting\SettingsFacade as Settings;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use App\Http\Controllers\TwoFactorController;
use App\Http\Resources\ProductResource;
use App\Models\Product as ModelsProduct;
use App\Models\ShippingCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/vendors', [PageController::class, 'vendors'])->name('vendors');

Route::any('/get-state', [PageController::class, 'getShops']);

Route::post('follow/{shop}', [PageController::class, 'follow'])->name('follow');
Route::get('liked/shops', [PageController::class, 'followShops'])->name('follow.shops');

Route::post('/add-address', [CheckoutController::class, 'userAddress'])->name('user.address.store');


Route::get('/', [PageController::class, 'home'])->name('homepage');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

Route::get('/product/{slug}', [PageController::class, 'product_details'])->name('product_details');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
// Route::get('/order_page', [PageController::class, 'order_page'])->name('order_page');
Route::get('/verify-email', [HomeController::class, 'verifyMassage'])->name('verify.massage');
Route::get('/thankyou', [PageController::class, 'thankyou'])->name('thankyou');

Route::post('/subscribe', [PageController::class, 'subscribe'])->name('subscribe');
Route::get('/quickview', [PageController::class, 'quickview'])->name('quickview');
Route::post('/offer/{product}', [HomeController::class, 'offer'])->name('offer');
Route::get('/offer-to-cart', [CartController::class, 'offerToCart'])->name('offer.cart');
Route::get('/set-location', [PageController::class, 'setLocation'])->name('set.location');
Route::get('/location-reset', [PageController::class, 'locationReset'])->name('location.reset');
// Route::get('/location-search', [PageController::class, 'locationSearch'])->name('location.search');
Route::get('/location-search', [PageController::class, 'locationSearchQuery'])->name('location.search.query');
Route::get('blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('blog/{slug}', [PageController::class, 'blogDetails'])->name('blog.details');

Route::get('alteration', [PageController::class, 'alteration'])->name('alteration');
Route::post('alteration', [PageController::class, 'alterationStore'])->name('alteration.store');




// Wishlist 
Route::get('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('wishlist-to-cart/{product_id}', [WishlistController::class, 'wishlistToCart'])->name('wishlistToCart');

//cart
Route::post('/add-cart', [CartController::class, 'add'])->name('cart.store');
Route::post('/buynow', [CartController::class, 'buynow'])->name('cart.boynow');
Route::post('/add-update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart-destroy/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart-qty', [CartController::class, 'cartQty'])->name('cart.qty');


//coupon routes
Route::post('/add-coupon', [CouponController::class, 'add'])->name('coupon');
Route::get('/delete-coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');


Route::group(['prefix' => 'checkout'], function () {
    Route::get('/add-billing-and-shipping-information', [CheckoutController::class, 'shippingAndBillingInformationPage'])->name('checkout.index');
    Route::post('/store-billing-and-shipping-information', [CheckoutController::class, 'storeBillingAndShippingInformation'])->name('checkout.storeBillingAndShippingInformation');
    Route::get('{order}/payment', [CheckoutController::class, 'paymentPage'])->name('checkout.paymentPage');
    Route::post('{order}/confirm-order', [CheckoutController::class, 'confirmOrder'])->name('checkout.confirmOrder');
});

Route::post('/store-checkout', [CheckoutController::class, 'store'])->name('checkout.store');

//Rating
Route::post('rating/{product_id}', [PageController::class, 'rating'])->name('rating');
// Route::get('/profile/{slug}', [PageController::class, 'store_front'])->name('store_front');
Route::get('/store/{shop:slug}', [PageController::class, 'store_front'])->name('store_front');




Auth::routes();

// Two-Factor Authentication routes
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor/challenge', [TwoFactorController::class, 'showChallenge'])->name('twofactor.challenge');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('twofactor.verify');
    Route::get('/two-factor/resend', [TwoFactorController::class, 'resend'])->name('twofactor.resend');
});



Route::get('admin/payout/{order}', [PayoutsController::class, 'payouts'])->name('payout')->middleware('auth', 'role:admin');

Route::get('admin/order/canceled', [PayoutsController::class, 'cancel_order'])->name('cancel.order')->middleware('auth', 'role:admin');
Route::get('admin/order/refund', [PayoutsController::class, 'refund'])->name('refund.order')->middleware('auth', 'role:admin');
Route::post('/refund/store', [PayoutsController::class, 'refund_store'])->name('refund.store');


// New comprehensive vendor registration form
Route::get('/vendor-registration', [PageController::class, 'vendorRegistration'])->name('vendor.registration');
Route::post('/vendor-registration', [PageController::class, 'vendorRegistrationStore'])->name('vendor.registration.store');
Route::get('/vendor-register-2nd-step', [HomeController::class, 'vendorSecondStep'])->name('vendor.second.step');
Route::post('/2nd-step-store', [HomeController::class, 'vendorSecondStepStore'])->name('vendor.second.step.store');

// Store Profile Setup Routes
Route::get('/store-profile-setup', [HomeController::class, 'storeProfileSetup'])->name('store.profile.setup')->middleware(['auth']);
Route::post('/store-profile-store', [HomeController::class, 'storeProfileStore'])->name('store.profile.store')->middleware(['auth']);

// Check Shop Status Route
Route::get('/check-shop-status', [HomeController::class, 'checkShopStatus'])->name('check.shop.status')->middleware(['auth']);


Route::get('/shop/set-up-payment-method', [PaymentsController::class, 'setUpPaymentMethod'])->middleware('auth', 'verifiedEmail', 'second')->name('vendor.setUpPaymentMethod');
Route::get('/admin/orders/details/{order}', [AdminController::class, 'orderDetails'])->name('admin.order.details')->middleware('auth', 'role:admin');

Route::get('email/{offer}', function (Offer $offer) {
    return new OfferEmail($offer);
});


Route::get('verify/email', [HomeController::class, 'verifyEmail'])->name('verify.token');
Route::get('/agian/verify/email', [HomeController::class, 'againVerifyEmail'])->name('again.verify.token');

Route::get('page/{slug}', [PageController::class, 'getPage']);
Route::get('faqs', [PageController::class, 'faqs'])->name('faqs');

Route::post('vendor/tickets/{ticket}', [TicketsController::class, 'reply'])->name('ticket.reply');
Route::get('ticket/{ticket}', [TicketsController::class, 'show'])->name('ticket.show');
Route::get('ticket/close/{ticket}', [TicketsController::class, 'close'])->name('ticket.close');


Route::get('/seen/{notification}', [MassageController::class, 'seen'])->name('massage.seen');
Route::get('/massage/{id?}', [MassageController::class, 'create'])->name('massage.create')->middleware('auth');
Route::get('/massage/store/{id}', [MassageController::class, 'store'])->name('massage.store')->middleware('auth');


Route::group(['prefix' => 'admin', 'middleware' => 'admin.user'], function () {
    Route::get('/shop/{shop}/active', [HomeController::class, 'shopActive'])->name('admin.shop.active');
    Route::get('/shop/{shop}/freeforlife', [HomeController::class, 'freeforlife'])->name('admin.shop.freeforlife');
});

Route::get('hello/{order}', function (Order $order) {
    return new OrderPlaced($order, $order);
    // return  Mail::to($order->email)->send(new OrderPlaced($order));
});

Route::post('/admin/shops/{shop}/toggle-status', [AdminController::class, 'toggleShopStatus'])
    ->name('filament.admin.resources.shops.toggle-status')
    ->middleware(['auth', 'role:admin']);

Route::post('/status-update/{shop}', [PageController::class, 'shop_status_update'])->name('shop_status_update');

Route::post('settings/update', [PageController::class, 'settingsUpdate'])->middleware(['auth', 'role:admin'])->name('settings.update');



Route::get('faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms.conditions');
Route::get('account-deletion', [PageController::class, 'accountDeletion'])->name('account.deletion');
Route::get('contact', [PageController::class, 'contact'])->name('contact');
Route::post('contact', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('payment/cancel', [PageController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('why-sell-on-royalit', [PageController::class, 'whySellOnAfrikart'])->name('why.sell.on.afrikart');
Route::get('sellers-helps', [PageController::class, 'sellersHelps'])->name('sellers.helps');
Route::get('/stripe/handle/{order}', [CheckoutController::class, 'handle'])->name('payment.handle');
Route::get('payment/handle/paypal/{order}', [CheckoutController::class, 'handlePaypal'])->name('payment.handle.paypal');


Route::get('email', function () {
    return new ShopCreatedEmail(Shop::latest()->first());
});
// API Documentation Route
Route::get('/api-docs', function () {
    return view('pages.api-docs');
})->name('api.docs');

Route::get('test', function () {
    return Settings::setting('stripe_secret');
});

// Store selected country in session
Route::post('/set-country', function (Request $request) {
    $name = $request->input('name');
    $flag = $request->input('flag');
    if ($name === 'global') {
        // Remove country filter
        Session::forget('myCountry');
        Cache::flush();
        return response()->json(['ok' => true, 'message' => 'Country cleared']);
    }
    if (!$name || !$flag) {
        return response()->json(['ok' => false, 'message' => 'Invalid payload'], 422);
    }

    session(['myCountry' => ['name' => $name, 'flag' => $flag]]);
    return response()->json(['ok' => true]);
})->name('set.country');
Route::post('/clear-home-cache', function () {
    Cache::flush();
    return response()->json(['status' => 'cleared']);
})->name('clear.home.cache');




Route::group(['prefix' => 'register-as-seller'], function () {
    Route::get('/', [RegistrationController::class, 'basicInfo'])->name('vendor.create');
    Route::post('/store', [VendorRegisterController::class, 'register'])->name('vendor.register.store');
    Route::middleware(['auth', 'verifiedEmail'])->group(function () {
        Route::get('terms-and-conditions', [RegistrationController::class, 'termsAndConditions'])->name('vendor.registration.terms-and-conditions');
        Route::post('terms-and-conditions', [RegistrationController::class, 'termsAndConditionsStore'])->name('vendor.registration.terms-and-conditions.store');
        Route::get('/vendor-verification', [RegistrationController::class, 'vendorVerification'])->name('vendor.registration.verification');
        Route::post('/vendor-verification/store', [RegistrationController::class, 'vendorVerificationStore'])->name('vendor.registration.verification.store');
        Route::get('/shop-info', [RegistrationController::class, 'shopInfo'])->name('vendor.registration.shop-info');
        Route::post('/shop-info/store', [RegistrationController::class, 'shopInfoStore'])->name('vendor.registration.shop-info.store');
        Route::post('shop-info/draft', [RegistrationController::class, 'shopInfoDraft'])->name('vendor.registration.shop-info.draft');
    });
});


Route::get('json/countries', function () {
    return (new CountryStateCity())->countries();
});
Route::get('json/states/{country}', function ($country) {
    return (new CountryStateCity())->states($country);
});
Route::get('json/cities/{country}/{state}', function ($country, $state) {
    return (new CountryStateCity())->cities($country, $state);
});

// Search endpoints for country/state by name or code
Route::get('api/geo/search/country', function (Request $request) {
    $q = $request->query('q');
    if (!$q) {
        return response()->json([], 200);
    }
    $svc = new CountryStateCity();
    return response()->json($svc->searchCountries($q));
});

Route::get('api/geo/search/state', function (Request $request) {
    $country = $request->query('country');
    $q = $request->query('q');
    if (!$country || !$q) {
        return response()->json([], 200);
    }
    $svc = new CountryStateCity();
    return response()->json($svc->searchStates($country, $q));
});

// Resolve endpoints: map name/code to canonical dataset row
Route::get('api/geo/resolve/country', function (Request $request) {
    $needle = $request->query('needle');
    if (!$needle) return response()->json([], 200);
    $svc = new CountryStateCity();
    $row = $svc->findCountry($needle);
    return response()->json($row ?: []);
});

Route::get('api/geo/resolve/state', function (Request $request) {
    $country = $request->query('country');
    $needle = $request->query('needle');
    if (!$country || !$needle) return response()->json([], 200);
    $svc = new CountryStateCity();
    $row = $svc->findState($country, $needle);
    return response()->json($row ?: []);
});


Route::get('test', function () {
    $products = ModelsProduct::where('is_variable_product', 1)->first();
    return ProductResource::make($products);
});

Route::get('vendor/verification-pending', [HomeController::class, 'verificationPending'])->name('vendor.verification');
Route::post('vendor/vendor-profile-page', [HomeController::class, 'logoCover'])->middleware('auth', 'verifiedEmail', 'second')->name('vendor.logo.cover');
Route::post('vendor/personal-info', [HomeController::class, 'personalInfoUpdate'])->name('vendor.personal_info');
Route::post('/vendor/update-password', [HomeController::class, 'updatePassword'])
    ->name('vendor.update_password');

// CSRF token refresh endpoint
Route::get('refresh-csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('web');


Route::get('eash-ship', function () {
    $eashShip = new EashShipProvider();
    $rates = $eashShip->getCategories();
    foreach ($rates['item_categories'] as $category) {
        ShippingCategory::updateOrCreate(
            ['id' => $category['id']], // match by id
            [
                'name' => $category['name'],
                'slug' => $category['slug'],
                'hs_code' => $category['hs_code'],
                'active' => $category['active'],
                'includes_battery' => $category['includes_battery'],
                'contains_battery_pi966' => $category['contains_battery_pi966'],
                'contains_battery_pi967' => $category['contains_battery_pi967'],
                'contains_liquids' => $category['contains_liquids'],
            ]
        );
    }

    return 'Item categories synced successfully';
});
Route::get('random', function () {
    return view('errors.503');
});

route::get('test-shop-info', function () {
    return view('auth.seller.registration.terms-and-condition');
});