<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Models\User;
use BondarDe\LaravelToolbox\Support\OneTimePasswordUtil;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class SecondFactorEnableStartController
{
    public function __invoke(Request $request, TwoFactorAuthenticationProvider $provider)
    {
        $secretKey = $provider->generateSecretKey();
        $recoveryCodes = OneTimePasswordUtil::makeRecoveryCodes();

        $svg = OneTimePasswordUtil::toSvg($secretKey, $request->user()->{User::FIELD_EMAIL});
        $secretKeyEncrypted = encrypt($secretKey);
        $recoveryCodesEncrypted = encrypt(json_encode($recoveryCodes));

        $pageTitle = __('Two Factor Authentication') . ': ' . __('Enable');

        return view('profile.enable-second-factor', compact(
            'pageTitle',
            'secretKey',
            'recoveryCodes',
            'svg',
            'secretKeyEncrypted',
            'recoveryCodesEncrypted',
        ));
    }
}
