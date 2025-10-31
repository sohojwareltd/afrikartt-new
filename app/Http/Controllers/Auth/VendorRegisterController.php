<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Filament\Pages\Auth\Register;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VendorRegisterController extends RegisterController
{
 protected function create(array $data)
    {

        $array = [
            'name'     => $data['name'],
            'l_name'   => $data['l_name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => 3,

        ];
        $user         = User::create($array);
        $verify_token = Str::random(20);

        if ($data['role_id'] == 3) {
            // Mail::to(setting('site.email'))->send(new NotifyEmail($user));
            Mail::to($user->email)->send(new VerifyEmail($user, $verify_token));
        }

        return $user;
    }

}