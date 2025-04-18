<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->token);

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'last_name' => '',
                    'phone' => '',
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(10)),
                ]
            );


            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function loginWithFacebook(Request $request)
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->userFromToken($request->token);

            $user = User::firstOrCreate(
                ['email' => $facebookUser->getEmail()],
                [
                    'name' => $facebookUser->getName(),
                    'last_name' => '',
                    'phone' => '',
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(10)),
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
