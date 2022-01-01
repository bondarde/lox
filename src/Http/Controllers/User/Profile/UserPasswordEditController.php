<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Http\Controllers\BaseController;

class UserPasswordEditController extends BaseController
{
    public function __invoke()
    {
        return self::viewWithFallback('profile.update-password');
    }
}
