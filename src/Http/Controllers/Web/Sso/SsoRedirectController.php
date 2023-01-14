<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Web\Sso;

use Laravel\Socialite\Facades\Socialite;

class SsoRedirectController
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
