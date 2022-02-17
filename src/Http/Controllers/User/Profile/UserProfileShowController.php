<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use Illuminate\Http\Request;

class UserProfileShowController
{
    public function __invoke(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }
}
