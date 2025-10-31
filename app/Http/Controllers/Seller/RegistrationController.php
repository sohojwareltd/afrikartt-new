<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\VendorVerificationSuccess;
use App\Models\Address;
use App\Models\Shop;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Settings;

class RegistrationController extends Controller
{
    public function basicInfo()
    {

        if (auth()->check() && auth()->user()->first_step_completed) {

            return redirect()->route('vendor.registration.terms-and-conditions');
        }
        return view('auth.seller.registration.basic-information');
    }
    public function verifyMassage()
    {
        return view('auth.seller.registration.email-verification');
    }
    public function termsAndConditions()
    {
        if (auth()->user()->third_step_completed) {
            return redirect()->route('vendor.registration.verification');
        }
        return view('auth.seller.registration.terms-and-condition');
    }
    public function shopInfo()
    {
        if (auth()->user()->fifth_step_completed) {
            return redirect('/vendor');
        }
        return view('auth.seller.registration.shop-info');
    }

    public function termsAndConditionsStore(Request $request)
    {
        if (auth()->user()->third_step_completed) {
            return redirect()->route('vendor.registration.verification');
        }
        $request->validate([
            'signature' => 'required',
        ]);


        // Handle signature
        $signatureData = $request->signature;
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData = str_replace(' ', '+', $signatureData);
        $signatureImage = base64_decode($signatureData);
        $fileName = 'signature_' . time() . '.png';
        Storage::disk('public')->put('signatures/' . $fileName, base64_decode($signatureData));

    

        $verification = Verification::updateOrCreate(['user_id' => auth()->id()], [
            'phone' => '',
            'address' => '',
            'signature' => 'signatures/' . $fileName,
        ]);


        $user = User::find(auth()->id());
        $user->createMeta('third_step_completed', true);

        return redirect()->route('vendor.registration.verification')->with('success', 'Verification created successfully');
    }


    public function vendorVerification()
    {
        if (auth()->user()->fourth_step_completed) {
            return redirect('/vendor');
        }
        return view('auth.seller.registration.vendor-information');
    }
    public function shopInfoStore(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array|min:1',
            'shipping.packaging_method' => 'required|string',
            'shipping.methods' => 'required|array',
            'shipping.delivery_time' => 'required|string',
            'shipping.tracking' => 'required|boolean',
            'marketing.logo' => 'required|string', // Assuming base64 or path
            'marketing.website_url' => 'nullable|url',
            'marketing.social_media.facebook' => 'nullable|url',
            'marketing.social_media.instagram' => 'nullable|url',
            'marketing.social_media.twitter' => 'nullable|url',
            'marketing.social_media.linkedin' => 'nullable|url',
            'agreement.terms' => 'required|accepted',
            'agreement.customer_support' => 'required|boolean',
            'agreement.quality_standards' => 'required|boolean',
        ]);

        try {
            $shopInfo = [
                'products' => $request->products,
                'shipping' => $request->shipping,
                'marketing' => $request->marketing,
                'agreement' => $request->agreement,
                'submitted_at' => now()->toDateTimeString(),
            ];

            // Update or create shop with shop_info
            Shop::updateOrCreate(
                ['user_id' => Auth::id()],
                ['shop_info' => $shopInfo]
            );

            return redirect()->back()->with('success', 'Registration submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit registration.');
        }
    }

    public function shopInfoDraft(Request $request)
    {
        try {
            $shopInfo = [
                'products' => $request->products ?? [],
                'shipping' => $request->shipping ?? [],
                'marketing' => $request->marketing ?? [],
                'agreement' => $request->agreement ?? [],
                'draft_saved_at' => now()->toDateTimeString(),
            ];

            Shop::updateOrCreate(
                ['user_id' => Auth::id()],
                ['shop_info' => $shopInfo]
            );

            return response()->json(['success' => true, 'message' => 'Draft saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save draft.']);
        }
    }
    public function vendorVerificationStore(Request $request)
    {
        if (auth()->user()->fourth_step_completed) {
            return redirect('/vendor');
        }
        $validationRules = [
            'phone' => ['required', 'string', 'regex:/^\\+?[0-9\\s()\-.]{7,20}$/'],
            'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(12)->format('Y-m-d')],
            'tax_no' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'min:5', 'max:500'],
            'country' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'post_code' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-\s]{3,10}$/'],
            'govt_id_back' => ['required', 'file', 'mimes:jpeg,png', 'max:5120'], // 5MB
            'govt_id_front' => ['required', 'file', 'mimes:jpeg,png', 'max:5120'], // 5MB

            'company_registration' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'store_email' => ['required', 'email:rfc,dns', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
        ];



        $data = $request->validate($validationRules);



        $user = User::find(auth()->id());

        $verification = Verification::updateOrCreate(['user_id' => auth()->id()], [
            'phone' => $request->phone,
            'govt_id_front' => $request->file('govt_id_front') ? $request->file('govt_id_front')->storeAs('verifications', $request->file('govt_id_front')->hashName(), 'public') : null,
            'govt_id_back' => $request->file('govt_id_back') ? $request->file('govt_id_back')->storeAs('verifications', $request->file('govt_id_back')->hashName(), 'public') : null,
            'address' => $request->address,
            'ismonthly_charge' => $request->ismonthly_charge,
        ]);

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

        $slug = $this->validateSlug($request->name);
        Shop::create([
            'user_id' => auth()->id(),
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
        $user->createMeta('fourth_step_completed', true);

        // Send notification email
        Mail::to(Settings::setting('admin_email'))->send(new VendorVerificationSuccess($user, $verification));

        return redirect('/vendor')->with('success_msg', 'Thanks for your information.');
    }

    protected function validateSlug($name)
    {
        $base = Str::slug((string) $name);
        if ($base === '' || $base === null) {
            $base = 'shop';
        }

        // First try the base slug as-is
        if (!Shop::where('slug', $base)->exists()) {
            return $base;
        }

        // Collect existing slugs that start with the base
        $existing = Shop::where('slug', 'like', $base . '%')->pluck('slug')->all();
        $existingSet = array_flip($existing);

        // Try numeric suffixes (base-2, base-3, ...)
        $suffix = 2;
        while ($suffix < 1000) { // reasonable upper bound
            $candidate = $base . '-' . $suffix;
            if (!isset($existingSet[$candidate]) && !Shop::where('slug', $candidate)->exists()) {
                return $candidate;
            }
            $suffix++;
        }

        // Fallback: randomized suffix to avoid race conditions
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $rand = strtolower(Str::random(6));
            $candidate = $base . '-' . $rand;
            if (!Shop::where('slug', $candidate)->exists()) {
                return $candidate;
            }
        }

        // Last resort: timestamp-based suffix
        return $base . '-' . now()->format('YmdHis');
    }
}
