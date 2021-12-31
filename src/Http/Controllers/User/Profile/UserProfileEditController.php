<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use Illuminate\Http\Request;

class UserProfileEditController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return view('profile.edit-profile-information', compact(
            'user',
        ));
    }
}
