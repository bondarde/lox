<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class UserProfileEditController extends BaseController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return self::viewWithFallback('profile.edit-profile-information', compact(
            'user',
        ));
    }
}
