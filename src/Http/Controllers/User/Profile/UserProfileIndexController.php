<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Services\UserService;
use Illuminate\Http\Request;

class UserProfileIndexController
{
    public function __invoke(Request $request, UserService $userService)
    {
        $user = $request->user();
        $sessions = $userService->getSessions($user);

        $view = config('lox.views.profile.index');

        return view($view, compact(
            'user',
            'sessions',
        ));
    }
}
