<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Models\User;
use BondarDe\LaravelToolbox\Http\Controllers\BaseController;
use BondarDe\LaravelToolbox\Http\Requests\User\Profile\RecoveryCodesResetRequest;
use BondarDe\LaravelToolbox\Support\OneTimePasswordUtil;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class RecoveryCodesResetConfirmController extends BaseController
{
    public function __invoke(RecoveryCodesResetRequest $request, TwoFactorAuthenticationProvider $provider)
    {
        $data = $request->validated();
        $code = $data[RecoveryCodesResetRequest::CONFIRMATION_CODE];
        $user = $request->user();
        $secret = decrypt($user->{User::FIELD_TWO_FACTOR_SECRET});

        $verificationPassed = $provider->verify($secret, $code);

        if (!$verificationPassed) {
            throw ValidationException::withMessages([
                RecoveryCodesResetRequest::CONFIRMATION_CODE => __('Invalid confirmation code'),
            ]);
        }

        $recoveryCodes = OneTimePasswordUtil::makeRecoveryCodes();

        $user
            ->forceFill([
                User::FIELD_TWO_FACTOR_RECOVERY_CODES => $recoveryCodes,
            ])
            ->save();

        $pageTitle = __('Your new recovery codes');

        return self::viewWithFallback('profile.show-new-recovery-codes', compact(
            'pageTitle',
            'recoveryCodes',
        ))
            ->with('success-message', __('Recovery codes have been reset'));
    }
}
