<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Http\Controllers\BaseController;

class UserPasswordEditController extends BaseController
{
    public function __invoke()
    {
        return self::viewWithFallback('profile.update-password');
    }
}
