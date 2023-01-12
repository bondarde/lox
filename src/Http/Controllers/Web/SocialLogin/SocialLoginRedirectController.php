<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginRedirectController extends Controller
{
    public function __invoke(string $provider)
    {
        $driver = match ($provider) {
            'twitter' => Socialite::with('Twitter'),
            default => Socialite::driver($provider),
        };

        return $driver
            ->redirect();
    }
}
