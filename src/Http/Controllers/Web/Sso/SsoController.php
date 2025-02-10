<?php

namespace BondarDe\Lox\Http\Controllers\Web\Sso;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Fortify\Features;

abstract class SsoController
{
    protected function validateSsoProvider(
        string $provider,
        Request $request,
    ) {
        $key = self::toKey($request);

        // user is blocked by IPs
        if (Cache::get($key) !== null) {
            self::cookTea();
        }

        // valid provider was called
        if (Features::optionEnabled('sso', $provider)) {
            return;
        }

        // block user by IPs
        Cache::put($key, true, now()->addHour());
        self::cookTea();
    }

    private static function cookTea()
    {
        abort(418, 'Are you a tee connoisseur?');
    }

    private static function toKey(Request $request): string
    {
        return 'lox:sso:blocked-' . implode(',', $request->getClientIps());
    }
}
