<?php

namespace BondarDe\Lox\Http\Controllers\Web\Sso;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SsoRedirectController extends SsoController
{
    public function __invoke(
        string $provider,
        Request $request,
    ) {
        $this->validateSsoProvider($provider, $request);

        $driver = match ($provider) {
            'twitter' => Socialite::with('Twitter'),
            default => Socialite::driver($provider),
        };

        return $driver
            ->redirect();
    }
}
