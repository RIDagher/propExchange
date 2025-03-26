<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller 
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            $user = User::firstOrCreate (
                ['email' => $socialUser->getEmail()],
                [
                    'username' => $socialUser->getName(),
                    'password' => Hash::make(uniqid()),
                    'role' => 'client',
                ]
            );
            Auth::login($user);
            return redirect()->intended('/')->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to login using Google');
        }
    }
}
