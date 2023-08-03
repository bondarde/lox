<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Http\Controllers\BaseController;

class SecondFactorDisableStartController extends BaseController
{
    public function __invoke()
    {
        $pageTitle = __('Two Factor Authentication') . ': ' . __('Disable');

        return self::viewWithFallback('profile.disable-second-factor', compact(
            'pageTitle',
        ));
    }
}
