<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OAuthProviderEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthProviderController extends Controller
{

    public function index(OAuthProviderEnum $provider): RedirectResponse
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function store(OAuthProviderEnum $provider): RedirectResponse
    {
        $oauthUser = Socialite::driver($provider->value)->user();

        $user = User::firstOrCreate([
            'email' => $oauthUser->getEmail(),
        ], [
            'name' => $oauthUser->getName(),
        ]);

        $user->providers()->updateOrCreate([
            'provider' => $provider->value,
            'provider_id' => $oauthUser->getId(),
        ]);

        Auth::login($user);

        return redirect(config('app.frontend_url') . '/dashboard');
    }
}
