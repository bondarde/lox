<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin;

use Laravel\Socialite\Facades\Socialite;

class SocialLoginRedirectController
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
