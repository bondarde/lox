<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Http\Controllers\BaseController;
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
