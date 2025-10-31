<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LocalAdminController extends Controller
{
    public function __construct()
    {
        // Only allow access in local environment
        $this->middleware(function ($request, $next) {
            if (!app()->environment('local')) {
                abort(404);
            }
            return $next($request);
        });
    }

    /**
     * Show the local admin dashboard
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $type = $request->get('type', 'users'); // 'users' or 'shops'
        
        if ($type === 'shops') {
            $shops = Shop::with('user')
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('slug', 'like', "%{$search}%")
                          ->orWhereHas('user', function ($q) use ($search) {
                              $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                          });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            
            return view('local-admin.index', compact('shops', 'search', 'type'));
        } else {
            $users = User::when($search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('l_name', 'like', "%{$search}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            
            return view('local-admin.index', compact('users', 'search', 'type'));
        }
    }

    /**
     * Login as a specific user
     */
    public function loginAsUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        // Store original admin user ID in session for logout
        session(['original_admin_id' => Auth::id()]);
        
        // Login as the selected user
        Auth::login($user);
        
        // Clear any 2FA requirements for this session
        session()->forget('two_factor_verified');
        session()->forget('two_factor_code');
        
        return redirect()->route('homepage')->with('success_msg', "Logged in as {$user->name} ({$user->email})");
    }

    /**
     * Login as a shop owner
     */
    public function loginAsShop(Request $request, $shopId)
    {
        $shop = Shop::with('user')->findOrFail($shopId);
        
        if (!$shop->user) {
            return back()->with('error', 'Shop has no associated user');
        }
        
        // Store original admin user ID in session for logout
        session(['original_admin_id' => Auth::id()]);
        
        // Login as the shop owner
        Auth::login($shop->user);
        
        // Clear any 2FA requirements for this session
        session()->forget('two_factor_verified');
        session()->forget('two_factor_code');
        
        return redirect()->route('homepage')->with('success_msg', "Logged in as shop owner: {$shop->user->name} (Shop: {$shop->name})");
    }

    /**
     * Return to original admin user
     */
    public function returnToAdmin()
    {
        $originalAdminId = session('original_admin_id');
        
        if (!$originalAdminId) {
            return redirect()->route('homepage')->with('error', 'No original admin session found');
        }
        
        $originalAdmin = User::find($originalAdminId);
        
        if (!$originalAdmin) {
            return redirect()->route('homepage')->with('error', 'Original admin user not found');
        }
        
        // Clear the original admin session
        session()->forget('original_admin_id');
        
        // Login as original admin
        Auth::login($originalAdmin);
        
        return redirect()->route('local-admin.index')->with('success_msg', 'Returned to admin account');
    }

    /**
     * Create a new test user
     */
    public function createTestUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return back()->with('success_msg', "Test user '{$user->name}' created successfully");
    }

    /**
     * Create a new test shop
     */
    public function createTestShop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:shops',
            'user_id' => 'required|exists:users,id',
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'user_id' => $request->user_id,
            'status' => true,
        ]);

        return back()->with('success_msg', "Test shop '{$shop->name}' created successfully");
    }
}
