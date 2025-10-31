<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::guard('sanctum')->user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            $avatar = $request->file('avatar')->store('users');
        } else {
            $avatar = $user->avatar;
        }

        if ($request->has('meta')) {
            $user->createMetas($request->meta);
        }

        $user->update([
            'name' => $request->first_name,
            'l_name' => $request->last_name,
            'avatar' => $avatar,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
            'user' => $user->fresh()
        ]);
    }
    public function updatePassword(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'current_password' => ['required', 'current_password:sanctum'],
        'new_password' => ['required', 'min:6', 'different:current_password'],
        'new_confirm_password' => ['same:new_password'],
    ]);
    
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    $user = Auth::guard('sanctum')->user();
    $user->update([
        'password' => Hash::make($request->new_password),
    ]);
    return response()->json([
        'status' => true,
        'message' => 'Password changed successfully'
    ]);
    }
}
