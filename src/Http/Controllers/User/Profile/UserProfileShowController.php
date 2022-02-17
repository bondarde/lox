<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Services\UserService;
use Illuminate\Http\Request;

class UserProfileShowController
{
    public function __invoke(Request $request, UserService $userService)
    {
        $user = $request->user();
        $sessions = $userService->getSessions($user);

        return view('profile.show', compact(
            'user',
            'sessions',
        ));
    }
}
