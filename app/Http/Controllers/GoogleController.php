<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $userFromGoogle = Socialite::driver('google')->stateless()->user();
    
            $userFromDb = User::updateOrCreate(
                ['email' => $userFromGoogle->getEmail()],
                [
                    'name'      => $userFromGoogle->getName(),
                    'google_id' => $userFromGoogle->getId(),
                    'username'  => explode('@', $userFromGoogle->getEmail())[0],
                    'password'  => bcrypt('password_google'),
                    'image'     => $userFromGoogle->getAvatar(),
                    'id_level'  => 3,
                ]
            );
    
            // Login user
            Auth::login($userFromDb);
            session()->regenerate();
    
            return redirect('/dashboard')->with('success', 'Berhasil login dengan Google');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }    
}
