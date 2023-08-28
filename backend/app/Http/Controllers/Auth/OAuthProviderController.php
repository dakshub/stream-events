<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthProviderController extends Controller
{

    public function index(Request $request): RedirectResponse
    {
        return Socialite::driver($request->provider)->redirect();
    }

    public function store(Request $request): RedirectResponse
    {
        $oauthUser = Socialite::driver($request->provider)->user();

        $user = User::firstOrCreate([
            'email' => $oauthUser->getEmail(),
        ], [
            'name' => $oauthUser->getName(),
        ]);

        Auth::login($user);

        return redirect(config('app.frontend_url') . '/dashboard');
    }
}
