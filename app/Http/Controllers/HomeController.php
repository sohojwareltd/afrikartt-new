<?php

namespace App\Http\Controllers;

use App\Mail\VendorVerificationSuccess;
use App\Mail\VerifyEmail;
use App\Models\Address;
use App\Models\BankAccount;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\User;
use App\Models\Product as ProductModel;
use App\Models\Shop;
use App\Models\Verification;
use App\Setting\Settings;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function againVerifyEmail()
    {
        $verify_token = Str::random(20);
        $user = auth()->user();
        Mail::to($user->email)->send(new VerifyEmail($user, $verify_token));
        return back()->with('success_msg', 'Resend email send successfully send');
    }

    public function verifyEmail()
    {
        $user = Auth()->user();
        $user->update([
            'remember_token' => request('token'),
            'email_verified_at' => now(),
        ]);
        $user->createMeta('second_step_completed', true);
        return redirect()->route('vendor.registration.terms-and-conditions');
    }
    public function verifyMassage()
    {
        return view('verify_massage');
    }
    public function vendorSecondStep()
    {
        $user = auth()->user();

        return view('auth.seller.second_step', [
            'intent' => $user->createSetupIntent()
        ]);
    }
    public function vendorSecondStepStore(Request $request)
    {

        $validationRules = [
            "phone" => "required",
            "dob"  => "required",
            "tax_no" =>  "nullable",
            "address" => "required",
            "country" => "required",
            "state" => "required",
            "city" => "required",
            "post_code" => "required",
            "govt_id_back" => "required|image|mimes:jpeg,png",
            "govt_id_front" => "required|image|mimes:jpeg,png",

            "company_registration" => "required",
            'name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'company_name' => 'required|string|max:255',
            // "payment_method_type" => "required|in:bank_account,paypal",
        ];

        // Add validation rules based on payment method type
        if ($request->payment_method_type === 'bank') {
            $validationRules = array_merge($validationRules, [
                'bank_name' => 'required|string|max:255',
                'account_holder' => 'required|string|max:255',
                'account_number' => 'required|string|max:50',
                'routing_number' => 'required|string|max:50',
                'account_type' => 'required|in:Checking,Savings',
                'currency' => 'required|string|max:3',
                'bank_address' => 'nullable|string|max:500',
                'swift_code' => 'nullable|string|max:50',
                'iban' => 'nullable|string|max:34',
            ]);
        }
        if ($request->payment_method_type === 'paypal') {
            $validationRules = array_merge($validationRules, [
                'paypal_email' => 'required|email|max:255',
                'paypal_email_confirmation' => 'required|same:paypal_email',
            ]);
        }
        // dd($request->payment_method_type === 'bank');

        $data = $request->validate($validationRules);

        // Handle signature
        $signatureData = $request->signature;
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData = str_replace(' ', '+', $signatureData);
        $signatureImage = base64_decode($signatureData);
        $fileName = 'signature_' . time() . '.png';
        $filePath = storage_path('app/public/signatures/' . $fileName);
        file_put_contents($filePath, $signatureImage);

        // Create Stripe subscription if needed
        Stripe::setApiKey(\App\Setting\Settings::setting('stripe_secret'));
        $product = Product::create([
            'name' => 'Basic Plan',
        ]);

        $price = Price::create([
            'product' => $product->id,
            'unit_amount' => 2495,
            'currency' => 'usd',
            'recurring' => [
                'interval' => 'month',
            ],
            'nickname' => 'basic-monthly',
        ]);
        $user = User::find(auth()->id());

        $sub = $user->newSubscription('basic', $price->id);
        if (setting('site.free_trial') == "on") {
            $sub->trialUntil(Carbon::now()->addDays(30));
        }

        // $sub->create($data['payment_method']);
        // Store bank account data if bank account method is selected
        // dd($request->payment_method_type === 'bank');
        if ($request->payment_method_type === 'bank') {
            BankAccount::create([
                'user_id' => auth()->id(),
                'bank_name' => $request->bank_name,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'routing_number' => $request->routing_number,
                'account_type' => $request->account_type,
                'currency' => $request->currency,
                'bank_address' => $request->bank_address,
                'swift_code' => $request->swift_code,
                'iban' => $request->iban,
                'is_default' => true, // First bank account is default
                'status' => 'active',
            ]);
        }

        // Create verification record
        $verificationData = [
            'user_id' => auth()->id(),
            'phone' => $request->phone,
            'govt_id_front' => $request->file('govt_id_front') ? $request->file('govt_id_front')->storeAs('verifications', $request->file('govt_id_front')->hashName(), 'public') : null,
            'govt_id_back' => $request->file('govt_id_back') ? $request->file('govt_id_back')->storeAs('verifications', $request->file('govt_id_back')->hashName(), 'public') : null,
            'address' => $request->address,
            'ismonthly_charge' => $request->ismonthly_charge,
            'signature' => 'signatures/' . $fileName,
        ];

        // Add payment method specific data to verification
        if ($request->payment_method_type == 'paypal') {
            $verificationData['paypal_email'] = $request->paypal_email;
        }

        $verification = Verification::create($verificationData);

        // Create address
        $Address = Address::create([
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'user_id' => auth()->id(),
            'address_1' => $request->address,
            'phone' => $request->phone,
        ]);

        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $count = 1;

        while (Shop::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-" . $count++;
        }
        Shop::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => $slug,
            'email' => $request->store_email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'company_registration' => $request->company_registration,
            'country' => $Address->country,
            'state' => $Address->state,
            'city' => $Address->city,
            'post_code' => $Address->post_code,
            'status' => 0,
        ]);


        // Send notification email
        Mail::to(Settings::setting('admin_email'))->send(new VendorVerificationSuccess($user, $verification));

        return redirect('/vendor')->with('success_msg', 'Thanks for your information. Your payment details have been saved successfully.');
    }
    public function offer(ProductModel $product, Request $request)
    {
        if ($product->sale_price) {
            $price = $product->sale_price;
        } else {
            $price = $product->price;
        }
        if ($request->price < $price) {
            Offer::create([
                'price' => $request->price,
                'qty' => $request->qty,
                'product_id' => $product->id,
                'shop_id' => $product->shop_id,
                'user_id' => Auth()->id(),
            ]);
            $this->notification(Auth()->id(), $product->shop_id);
            return redirect()->back()->with('success_msg', 'Offer create successfull ');
        } else {
            return back()->withErrors('Sorry! your price greater then product price');
        }
    }

    protected function notification($user, $shop)
    {
        Notification::create([
            'url' => env('APP_URL') . '/vendor/dasboard/offers',
            'title' => 'Offer Created',

            'shop_id' => $shop,
        ]);
    }

    public function shopActive(Shop $shop)
    {
        if ($shop->status == 0) {
            $shop->update([
                'status' => true,
            ]);
        } else {
            $shop->update([
                'status' => false,
            ]);
        }
        return back()->with([
            'message'    => "Shop Action create",
            'alert-type' => 'success',
        ]);
    }

    public function freeforlife(Shop $shop)
    {
        try {
            if ($shop->user->ffl == 0) {
                $shop->user->cancelSubscriptionNow();
                $shop->user->update([
                    'ffl' => true,
                ]);
            } else {
                $shop->user->update([
                    'ffl' => false,
                ]);
            }
            return back()->with([
                'message'    => "Shop is now free",
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * Show the store profile setup form
     */
    public function storeProfileSetup()
    {
        return view('auth.seller.store_profile');
    }

    /**
     * Store the store profile data
     */
    public function storeProfileStore(Request $request)
    {
        // Validate the form data
        $validationRules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'short_description' => 'required|string|max:250',
            'description' => 'required|string|max:1000',
            'company_name' => 'required|string|max:150',
            'company_registration' => 'nullable|string|max:50',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'post_code' => 'required|string|max:20',
        ];

        $data = $request->validate($validationRules);

        try {
            // Handle file uploads
            $logoPath = null;
            $bannerPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('banners', 'public');
            }

            // Check if user already has a shop
            $user = Auth::user();
            $shop = $user->shop;

            if ($shop) {
                // Update existing shop
                $shop->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'company_name' => $data['company_name'],
                    'company_registration' => $data['company_registration'],
                    'logo' => $logoPath ?: $shop->logo,
                    'banner' => $bannerPath ?: $shop->banner,
                    'country' => $data['country'],
                    'state' => $data['state'],
                    'city' => $data['city'],
                    'post_code' => $data['post_code'],
                ]);
            } else {
                // Create new shop
                $shop = Shop::create([
                    'user_id' => Auth::id(),
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'company_name' => $data['company_name'],
                    'company_registration' => $data['company_registration'],
                    'logo' => $logoPath,
                    'banner' => $bannerPath,
                    'country' => $data['country'],
                    'state' => $data['state'],
                    'city' => $data['city'],
                    'post_code' => $data['post_code'],
                    'status' => 'pending', // Set initial status
                ]);
            }

            return redirect()->route('vendor.verification')->with([
                'message' => 'Store profile created successfully! Your store is now under review.',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return back()->withInput()->with([
                'message' => 'Error creating store profile: ' . $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * Check shop status for verification page
     */
    public function checkShopStatus()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => 0,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $shop = $user->shop;

            if ($shop) {
                return response()->json([
                    'status' => (int) $shop->status,
                    'message' => $shop->status == 1 ? 'Shop approved' : 'Shop pending approval',
                    'shop_id' => $shop->id,
                    'shop_name' => $shop->name
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => 'No shop found for this user'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function verificationPending()
    {
        if (auth()->user()->fourth_step_completed) {

            return view('pages.verification_pending');
        } else {
            return redirect()->route('vendor.create');
        }
    }
    public function logoCover(Request $request)
    {
        if ($request->file('logo')) {
            if (auth()->user()->shop) {
                $oldLogo = auth()->user()->shop->logo; // get the old logo file name
                if ($oldLogo) {
                    Storage::delete($oldLogo); // delete the old logo file
                }
            }
            Shop::updateOrCreate(['user_id' => auth()->user()->id], [
                'logo' => $request->logo->store("logo"),
            ]);
            return back()->with('success_msg', 'Logo upload successfully');
        }

        if ($request->file('banner')) {
            if (auth()->user()->shop) {
                $oldBanner = auth()->user()->shop->banner; // get the old banner file name
                if ($oldBanner) {
                    Storage::delete($oldBanner); // delete the old banner file
                }
            }
            Shop::updateOrCreate(['user_id' => auth()->user()->id], [
                'banner' => $request->banner->store("banners"),
            ]);
            return back()->with('success_msg', 'Banner upload successfully');
        }
    }
    public function personalInfoUpdate(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name   = $validated['first_name'];
        $user->l_name = $validated['last_name'];
        $user->email  = $validated['email'];

        if ($request->hasFile('avatar')) {
            // delete old avatar if exists
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            // store new avatar
            $user->avatar = $request->file('avatar')->store('avatars');
        }

        $user->save();

        return back()->with('success_msg', 'Profile updated successfully!');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'          => ['required', 'current_password'],
            'new_password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success_msg', 'Password updated successfully!');
    }
}
