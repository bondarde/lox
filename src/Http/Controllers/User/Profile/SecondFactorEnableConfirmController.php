<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Models\User;
use BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Features;
use Laravel\Fortify\RecoveryCode;

class SecondFactorEnableConfirmController
{
    public function __invoke(SecondFactorEnableRequest $request, TwoFactorAuthenticationProvider $provider)
    {
        $user = $request->user();

        $secretKeyEncrypted = $request->{SecondFactorEnableRequest::SECRET_KEY};
        $recoveryCodesEncrypted = $request->{SecondFactorEnableRequest::RECOVERY_CODES};

        $secret = decrypt($secretKeyEncrypted);
        $code = $request->{SecondFactorEnableRequest::CONFIRMATION_CODE};

        $verificationPassed = $provider->verify($secret, $code);

        if (!$verificationPassed) {
            throw ValidationException::withMessages([
                SecondFactorEnableRequest::CONFIRMATION_CODE => __('Invalid confirmation code'),
            ]);
        }

        $user
            ->forceFill([
                User::FIELD_TWO_FACTOR_SECRET => $secretKeyEncrypted,
                User::FIELD_TWO_FACTOR_RECOVERY_CODES => $recoveryCodesEncrypted,
            ])
            ->save();

        return redirect(route('profile.show'))
            ->with('success-message', __('Enabled'));
    }
}
