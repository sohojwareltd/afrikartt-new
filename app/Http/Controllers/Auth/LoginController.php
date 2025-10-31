<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    // OTP is handled globally via Login event + middleware

    public function redirectTo()
    {
        // Check if there's a redirect parameter in the request (from form submission or URL)
        if (request()->has('redirect')) {
            return request()->get('redirect');
        }

        switch (auth()->user()->role_id) {
            case 1:
                return RouteServiceProvider::ADMIN;

            case 2:
                return RouteServiceProvider::USER;


            case 3:
                return RouteServiceProvider::VENDOR;

            case 4:
                return RouteServiceProvider::EMPLOYEE;
            default:
                return RouteServiceProvider::HOME;
        }
    }
}
