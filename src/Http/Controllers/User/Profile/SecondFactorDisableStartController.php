<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Http\Controllers\BaseController;

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
