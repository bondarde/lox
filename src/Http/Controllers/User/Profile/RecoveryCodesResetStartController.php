<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Http\Controllers\BaseController;

class RecoveryCodesResetStartController extends BaseController
{
    public function __invoke()
    {
        $pageTitle = __('Regenerate Recovery Codes');

        return self::viewWithFallback('profile.reset-recovery-codes', compact(
            'pageTitle',
        ));
    }
}
