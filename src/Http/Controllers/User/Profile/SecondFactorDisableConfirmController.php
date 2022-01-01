<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Models\User;
use BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorDisableRequest;
use BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class SecondFactorDisableConfirmController
{
    public function __invoke(SecondFactorDisableRequest $request, TwoFactorAuthenticationProvider $provider)
    {
        $data = $request->validated();
        $code = $data[SecondFactorDisableRequest::CONFIRMATION_CODE];
        $user = $request->user();
        $secret = decrypt($user->{User::FIELD_TWO_FACTOR_SECRET});

        $verificationPassed = $provider->verify($secret, $code);

        if (!$verificationPassed) {
            throw ValidationException::withMessages([
                SecondFactorEnableRequest::CONFIRMATION_CODE => __('Invalid confirmation code'),
            ]);
        }

        $user
            ->forceFill([
                User::FIELD_TWO_FACTOR_SECRET => null,
                User::FIELD_TWO_FACTOR_RECOVERY_CODES => null,
            ])
            ->save();

        return redirect(route('profile.show'))
            ->with('success-message', __('2FA has been disabled'));
    }
}
