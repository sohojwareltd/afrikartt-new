<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Address;
use App\Models\Email;
use App\Models\Order;
use App\Models\Page;
use App\Models\Prodcat;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Shop;
use App\Models\User;
use App\Models\Slider;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepsitory;
use App\Setting\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Cart;
use App\Facade\SohojFacade as Sohoj;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\ProdcatProduct;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function home()
    {

        $ip = request()->ip();

        $country = Session::get('detected_country');

        // clear if it's not US or valid
        if ($country && $country !== 'US') {
            Session::forget('detected_country');
            $country = null;
        }

        if (!$country) {
            $response = Http::get("https://ipwho.is/{$ip}");
            $data = $response->json();
            $country = strtoupper($data['country_code'] ?? 'US');

            // if BD, force US
            if ($country === 'BD') {
                $country = 'US';
            }

            Session::put('detected_country', $country);
        }



        $homeData = Cache::remember('homepage_data', 600, function () {
            $featuredProducts = Product::query()
                ->country()
                ->where('featured', true)
                ->whereNotNull('price')
                ->orderBy('featured_order', 'asc')
                ->take(12)
                ->get();
            $showcaseProducts = ProductRepository::getShowcaseProducts() ?: collect();
            return [
                'latest_products'   => ProductRepository::getLatestProducts() ?: collect(),
                'bestsaleproducts'  => ProductRepository::getBestsaleProducts() ?: collect(),
                'recommandProducts' => ProductRepository::getRecommandProducts() ?: collect(),
                'latest_shops'      => ShopRepsitory::getLatestShops() ?: collect(),
                'prodcats'          => CategoryRepository::getAllCategoriesWithProducts() ?: collect(),
                'showcaseProducts'  => $showcaseProducts,
                'allproducts'       => $featuredProducts ?: collect(),
            ];
        });

        $homeData['sliders'] = Slider::orderBy('order', 'asc')->get() ?: collect();

        return view('pages.home', $homeData);
    }



    public function shops()
    {

        $products = ProductRepository::getAllProducts();

        $categories = CategoryRepository::getAllParentCategories();

        $latest_shops =  ShopRepsitory::getLatestShops();

        return view('pages.shops', compact('products', 'categories', 'latest_shops'));
    }
    public function product_details($slug)
    {
        $mainProduct = Product::where('slug', $slug)->firstOrFail();
        $related_products = Product::whereNull('parent_id')->whereHas('prodcats', function ($query) use ($mainProduct) {
            $query->whereIn('prodcats.id', $mainProduct->prodcats->pluck('id'));
        })->where('status', 1)->take(12)->get();
        $mainProduct->increment('views');


        $recommand = session()->get('recommand', []);

        if (!in_array($mainProduct->id, $recommand)) {
            $recommand[] = $mainProduct->id;
            session()->put('recommand', $recommand);
        }
        return view('pages.product_details', compact('related_products', 'mainProduct'));
    }
    public function cart()
    {
        $latest_shops =  Shop::where("status", 1)
            ->whereHas('products', function ($query) {
                $query->whereNull('parent_id');
            })->latest()->limit(8)->get();
        return view('pages.cart', compact('latest_shops'));
    }


    public function dashboard()
    {
        // $intent = auth()->user()->createSetupIntent();
        return view('auth.user.dashboard');
    }
    public function addressEdit(Address $address)
    {
        return view('auth.user.information', ['address' => $address]);
    }
    public function addressDestroy(Address $address)
    {

        $address->delete($address);

        return back()->with('success_msg', 'Address has been removed!');
    }



    public function order_index()
    {
        $latest_orders = Order::where('user_id', auth()->user()->id)->where('status', 0)->orWhere('status', 3)->latest()->get();
        $past_orders = Order::where('user_id', auth()->user()->id)->where('status', 1)->latest()->get();

        return view('auth.user.order.index', compact('latest_orders', 'past_orders'));
    }


    public function checkout()
    {
        $items = Cart::content();
        $cartProductIds = $items->pluck('id')->toArray();

        $prices = Cart::subtotalFloat();
        $shipping = Sohoj::shipping();
        $flatCharge = Sohoj::flatCommision($prices);
        $discount = Sohoj::discount();
        $tax = Sohoj::tax();
        $total = $prices + $shipping + $flatCharge - $discount + $tax;

        $groupedItems = $items->groupBy(fn($item) => $item->model->shop_id);

        $products = Product::whereIn('id', $cartProductIds)
            ->get(['id', 'search_keywords']);

        $categoryIds = ProdcatProduct::whereIn('product_id', $cartProductIds)
            ->pluck('prodcat_id')
            ->unique()
            ->toArray();

        $keywords = $products->pluck('search_keywords')
            ->filter()
            ->unique()
            ->implode(' ');

        $related_products = Product::whereNotIn('id', $cartProductIds)
            ->where(function ($query) use ($categoryIds, $keywords) {
                if (!empty($categoryIds)) {
                    $query->whereIn('id', function ($subQuery) use ($categoryIds) {
                        $subQuery->select('product_id')
                            ->from('prodcat_product')
                            ->whereIn('prodcat_id', $categoryIds);
                    });
                }

                if (!empty($keywords)) {
                    $query->orWhere(fn($q) => $q->searchKeywords($keywords));
                }
            })
            ->inRandomOrder()
            ->limit(12)
            ->get();


        return view('pages.checkout', compact(
            'related_products',
            'prices',
            'shipping',
            'flatCharge',
            'discount',
            'tax',
            'total',
            'items',
            'groupedItems'
        ));
    }



    public function store_front(Shop $shop)
    {
        return view('pages.store_front', compact('shop'));
    }


    // public function order_page()
    // {
    //     return view('pages.order_page');
    // }
    public function thankyou()
    {
        $latest_products = Product::where("status", 1)->latest()->limit(24)->whereNull('parent_id')->get();
        return view('pages.thankyou', compact('latest_products'));
    }
    public function rating(Request $request)
    {
        //return $request->all();
        $product = Product::find($request->product_id);
        Rating::create([
            "name" => auth()->user()->name,
            "email" => auth()->user()->email,
            "rating" => intval($request->rating),
            "review" => $request->review,
            "product_id" => $product->id,
            'user_id' => Auth()->id(),
            'shop_id' => $product->shop->id,
        ]);
        return back()->with('success_msg', 'Thanks for your review');
        //return back()->withErrors('Sorry! One of the items in your cart is no longer Available!');
    }
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'unique:emails,email'],
        ], [
            'email.unique' => 'You already subscribed'
        ]);
        Email::create([
            "email" => $request->email,
        ]);
        return back()->with('subscribeEmail', 'Thanks for your subscription');
    }
    public function quickview()
    {
        $product = Product::where('id', request()->product_id)->first();
        return view('layouts.quick_view', compact('product'));
    }

    public function vendors(Request $request)
    {
        if (auth()->check() && $request->type == 'liked') {
            $shops = auth()->user()->followedShops()->active();
        } else {
            $shops = Shop::active();
        }
        $shops = $shops->country()->with(['products' => function ($query) {
            $query->whereHas('prodcats', function ($query) {
                $query->where('slug', request()->category);
            });
        }])
            ->when($request->filled('category'), function ($query) {
                $query->whereHas('products', function ($query) {
                    $query->whereHas('prodcats', function ($query) {
                        $query->where('slug', request()->category);
                    });
                });
            })->when(Session::has('post_city'), function ($q) {
                $post_city = Session::get('post_city');
                return $q->where(function ($qp) use ($post_city) {
                    $qp->where('post_code', 'like', '%' . $post_city . '%')->orWhere('city', 'like', '%' . $post_city . '%');
                });
            })->when(Session::has('state'), function ($q) {
                $state = Session::get('state');
                return $q->where('state', 'like', '%' . $state . '%');
            })
            ->get();
        return view('pages.vendors', compact('shops'));
    }

    public function follow(Shop $shop)
    {
        $user = auth()->user();

        $user->followedShops()->toggle($shop->id);

        if ($user->follows($shop)) {
            return redirect()->back()->with('success_msg', 'You are now following ' . $shop->name);
        } else {
            return redirect()->back()->with('success_msg', 'You have unfollowed ' . $shop->name);
        }
    }
    public function getPage($slug = null)
    {
        $page = Page::where('slug', 'about')->where('status', 'active')->first();
        return view('pages.page')->with('page', $page);
    }
    public function followShops()
    {
        return view('pages.likedShop');
    }
    public function setLocation(Request $request)
    {
        $postcodes = $request->input('postcodes');
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $radius = $request->input('radius');
        $state = $request->input('state');
        $uniquePostcodes = array_unique($postcodes);

        // Process the data as needed

        // Return the response
        $response = [
            'postcode' => $uniquePostcodes,
            'lng' => $lng,
            'lat' => $lat,
            'radius' => $radius,
            'state' => $state,
        ];
        Session::put('location', $response);

        return response()->json($response);
    }
    public function locationReset()
    {
        Session::forget('post_city');
        Session::forget('state');
        return back()->with('success_msg', 'Location reset Success');
    }
    public function locationSearchQuery(Request $request)
    {
        if ($request->filled('post_city')) {
            $postCityArray = session()->get('post_city', []);
            $updatedArray = array_merge($postCityArray, $request->input('post_city'));
            session()->put('post_city', $updatedArray);
        }
        if ($request->filled('state')) {
            session()->put('state', $request->input('state'));
        }
        return redirect(route('shops'));
    }
    public function getShops(Request $request)
    {
        $state = $request->input('state');
        $shops = Shop::where('state', $state)->pluck('city', 'city');
        // dd($shops);
        return response()->json($shops);
    }

    public function shop_status_update(Request $request, Shop $shop)
    {
        $status = $request->input('status') === 'activate' ? 1 : 0;
        $shop->update(['status' => $status]);

        return redirect()->back()->with('success', 'Shop status updated successfully.');
    }

    public function settingsUpdate(Request $request)
    {
        try {
            // Get all form data except the CSRF token and method
            $settings = $request->except(['_token', '_method']);

            foreach ($settings as $key => $value) {
                // Handle file uploads
                if ($request->hasFile($key)) {
                    $file = $request->file($key);

                    // Store file and get path
                    $filePath = $file->store('settings', 'public');
                    $value = $filePath;

                    // Delete old file if exists
                    $existingSetting = \App\Models\Setting::where('key', $key)->first();
                    if ($existingSetting && $existingSetting->value && \Storage::disk('public')->exists($existingSetting->value)) {
                        \Storage::disk('public')->delete($existingSetting->value);
                    }
                }

                // Handle array values (convert to JSON)
                if (is_array($value)) {
                    $value = json_encode($value);
                }

                // Use updateOrCreate to handle both updates and new entries
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key], // Search condition
                    [
                        'value' => $value,
                        'display_name' => ucwords(str_replace('_', ' ', $key)),
                        'type' => $this->determineSettingType($key, $value),
                        'group' => $this->determineSettingGroup($key),
                    ]
                );
            }

            // Clear settings cache if you're using caching
            if (function_exists('settings')) {
                \Cache::forget('settings');
            }

            return redirect()->back()->with('success_msg', 'Settings updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Settings update failed: ' . $e->getMessage());
            return redirect()->back()->with('error_msg', 'Failed to update settings. Please try again.');
        }
    }

    /**
     * Determine the setting type based on key and value
     */
    private function determineSettingType($key, $value)
    {
        // File types
        if (str_contains($key, 'logo') || str_contains($key, 'image') || str_contains($key, 'icon') || str_contains($key, 'banner')) {
            return 'file';
        }

        // Email types
        if (str_contains($key, 'email')) {
            return 'email';
        }

        // URL types
        if (str_contains($key, 'url') || str_contains($key, 'link')) {
            return 'url';
        }

        // Phone types
        if (str_contains($key, 'phone')) {
            return 'tel';
        }

        // Date types
        if (str_contains($key, 'date') || str_contains($key, 'valid_until')) {
            return 'date';
        }

        // Number types
        if (is_numeric($value)) {
            return 'number';
        }

        // Textarea for longer content
        if (str_contains($key, 'description') || str_contains($key, 'info') || str_contains($key, 'address')) {
            return 'textarea';
        }

        // Default to text
        return 'text';
    }

    /**
     * Determine the setting group based on key
     */
    private function determineSettingGroup($key)
    {
        if (str_starts_with($key, 'site_')) {
            return 'site';
        }

        if (str_starts_with($key, 'admin_')) {
            return 'admin';
        }

        if (str_contains($key, 'social') || str_contains($key, 'facebook') || str_contains($key, 'twitter') || str_contains($key, 'instagram') || str_contains($key, 'linkedin')) {
            return 'social';
        }

        if (str_contains($key, 'offer') || str_contains($key, 'promotion')) {
            return 'offer';
        }

        // Default group
        return 'general';
    }

    /**
     * Alternative method using Setting model directly (if you prefer this approach)
     */
    public function settingsUpdateAlternative(Request $request)
    {
        try {
            $settings = $request->except(['_token', '_method']);

            foreach ($settings as $key => $value) {
                // Handle file uploads
                if ($request->hasFile($key)) {
                    $value = $this->handleFileUpload($request->file($key), $key);
                }

                // Handle array values
                if (is_array($value)) {
                    $value = json_encode($value);
                }

                // Update or create setting
                $setting = \App\Models\Setting::firstOrNew(['key' => $key]);
                $setting->value = $value;

                // Set other attributes only if it's a new record
                if (!$setting->exists) {
                    $setting->display_name = ucwords(str_replace('_', ' ', $key));
                    $setting->type = $this->determineSettingType($key, $value);
                    $setting->group = $this->determineSettingGroup($key);
                    $setting->order = \App\Models\Setting::max('order') + 1;
                }

                $setting->save();
            }

            return redirect()->back()->with('success_msg', 'Settings updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Settings update failed: ' . $e->getMessage());
            return redirect()->back()->with('error_msg', 'Failed to update settings. Please try again.');
        }
    }

    /**
     * Handle file upload for settings
     */
    private function handleFileUpload($file, $key)
    {
        // Delete old file if exists
        $existingSetting = \App\Models\Setting::where('key', $key)->first();
        if ($existingSetting && $existingSetting->value && \Storage::disk('public')->exists($existingSetting->value)) {
            \Storage::disk('public')->delete($existingSetting->value);
        }

        // Store new file
        return $file->store('settings/' . date('Y/m'), 'public');
    }

    public function faqs()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('pages.faq', compact('faqs'));
    }

    public function privacyPolicy()
    {
        $privacyPolicy = Page::where('slug', 'privacy-policy')->where('status', 'ACTIVE')->first();
        return view('pages.privacy-policy', compact('privacyPolicy'));
    }

    public function termsAndConditions()
    {
        $termsAndConditions = Page::where('slug', 'terms-and-conditions')->where('status', 'ACTIVE')->first();
        return view('pages.terms-and-conditions', compact('termsAndConditions'));
    }

    public function accountDeletion()
    {
        $accountDeletion = Page::where('slug', 'account-deletion')->where('status', 'ACTIVE')->first();
        return view('pages.account-deletion', compact('accountDeletion'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $contactData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'order_number' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
            'privacy_agree' => 'required|accepted',
        ]);
        Mail::to(Settings::setting('admin_email'))->send(new ContactMessageMail($contactData));
        return redirect()->back()->with('success_msg', 'Thank you for your message! We will get back to you within 24 hours.');
    }

    public function paymentCancel()
    {
        return view('pages.payment_cancel');
    }

    public function whySellOnAfrikart()
    {
        $whySell = Page::where('slug', 'why-sell-on-afrikartt')->where('status', 'ACTIVE')->first();
        return view('pages.why_sell_on_afrikart', compact('whySell'));
    }

    public function sellersHelps()
    {
        $sellersHelps = Page::where('slug', 'sellers-helps')->where('status', 'ACTIVE')->first();
        return view('pages.sellers_helps', compact('sellersHelps'));
    }

    public function vendorRegistration()
    {
        $countries = \App\Data\Country\Africa::getCountries();
        return view('pages.vendor_registration', compact('countries'));
    }

    public function vendorRegistrationStore(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            // Company Information
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string|max:1000',
            'country_of_operation' => 'required|string|max:255',
            'legally_registered' => 'required|in:yes,no',
            'business_registration' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tax_identification' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',

            // Product Information
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.category' => 'required|string|max:255',
            'products.*.short_description' => 'required|string|max:500',
            'products.*.detailed_description' => 'required|string|max:1500',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.ethically_sourced' => 'required|in:yes,no',
            'products.*.images' => 'required|array|min:3',
            'products.*.images.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'products.*.certifications' => 'nullable|string|max:500',
            'products.*.complies_regulations' => 'required|in:yes,no',

            // Shipping & Packaging
            'packaging_method' => 'required|string|max:1000',
            'shipping_method' => 'required|string|max:255',
            'estimated_delivery_time' => 'required|string|max:255',
            'shipment_tracking' => 'required|in:yes,no',

            // Marketing & Brand Assets
            'brand_logo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'promotional_material' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'website_url' => 'nullable|url|max:255',
            'social_media_links' => 'nullable|string|max:1000',

            // Vendor Agreement
            'agree_terms' => 'required|accepted',
            'handle_customer_inquiries' => 'required|in:yes,no',
            'maintain_quality_standards' => 'required|in:yes,no',
        ]);

        try {
            // Handle file uploads
            $businessRegistrationPath = $request->file('business_registration')->store('vendor-documents', 'public');
            $brandLogoPath = $request->file('brand_logo')->store('vendor-logos', 'public');

            $promotionalMaterialPath = null;
            if ($request->hasFile('promotional_material')) {
                $promotionalMaterialPath = $request->file('promotional_material')->store('vendor-promotional', 'public');
            }

            // Handle product images
            $productsData = [];
            foreach ($request->products as $index => $product) {
                $productImages = [];
                foreach ($product['images'] as $image) {
                    $productImages[] = $image->store('vendor-products', 'public');
                }

                $productsData[] = [
                    'name' => $product['name'],
                    'category' => $product['category'],
                    'short_description' => $product['short_description'],
                    'detailed_description' => $product['detailed_description'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'ethically_sourced' => $product['ethically_sourced'],
                    'images' => $productImages,
                    'certifications' => $product['certifications'] ?? null,
                    'complies_regulations' => $product['complies_regulations'],
                ];
            }

            // Store vendor registration data (you can save to database or send email)
            $vendorData = [
                'company_name' => $validated['company_name'],
                'company_description' => $validated['company_description'],
                'country_of_operation' => $validated['country_of_operation'],
                'legally_registered' => $validated['legally_registered'],
                'business_registration_path' => $businessRegistrationPath,
                'tax_identification' => $validated['tax_identification'],
                'contact_person_name' => $validated['contact_person_name'],
                'contact_email' => $validated['contact_email'],
                'products' => $productsData,
                'packaging_method' => $validated['packaging_method'],
                'shipping_method' => $validated['shipping_method'],
                'estimated_delivery_time' => $validated['estimated_delivery_time'],
                'shipment_tracking' => $validated['shipment_tracking'],
                'brand_logo_path' => $brandLogoPath,
                'promotional_material_path' => $promotionalMaterialPath,
                'website_url' => $validated['website_url'],
                'social_media_links' => $validated['social_media_links'],
                'handle_customer_inquiries' => $validated['handle_customer_inquiries'],
                'maintain_quality_standards' => $validated['maintain_quality_standards'],
                'submitted_at' => now(),
            ];

            // Here you can save to database, send email, or process as needed
            // For now, we'll just return a success message

            return redirect()->back()->with('success', 'Your vendor registration has been submitted successfully! We will review your application and get back to you within 3-5 business days.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error submitting your registration. Please try again.')->withInput();
        }
    }


    public function blogs()
    {
        $blogs = Blog::where('is_published', true)->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(6);

        return view('pages.blogs.index', compact('blogs'));
    }
    public function blogDetails($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)->where('published_at', '<=', now())
            ->firstOrFail();

        $relatedBlogs = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('pages.blogs.details', compact('blog', 'relatedBlogs'));
    }
}
