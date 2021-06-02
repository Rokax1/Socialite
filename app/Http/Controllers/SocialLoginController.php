<?php

namespace App\Http\Controllers;

use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToSocialNetwork($socialNetwork)
    {

        return Socialite::driver($socialNetwork)->redirect();
    }

    public function handleSocialNetworkCallback($socialNetwork)
    {

        try {
            $socialUser = Socialite::driver($socialNetwork)->user();
            //dd($socialUser);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('warning', 'Hubo un error en el login...');
        }

        $socialProfile = SocialProfile::firstOrNew([
            'social_network' => $socialNetwork,
            'social_network_user_id' => $socialUser->getId()
        ]);

        if (!$socialProfile->exists) {
            $user = User::firstOrNew(['email' => $socialUser->getEmail()]);

            if (!$user->exists) {
                $user->name = $socialUser->getName();
                $user->save();
            }

            $socialProfile->avatar = $socialUser->getAvatar();

            $user->profiles()->save($socialProfile);
        }
//dd($socialProfile->user);
        Auth::login($socialProfile->user);

        return redirect()->route('dashboard')->with('success', 'Bienvenido ' . $socialProfile->user->name);
    }
}
