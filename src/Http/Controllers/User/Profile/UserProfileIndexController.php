<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Services\UserService;
use Illuminate\Http\Request;

class UserProfileIndexController
{
    public function __invoke(Request $request, UserService $userService)
    {
        $user = $request->user();
        $sessions = $userService->getSessions($user);

        $view = config('laravel-toolbox.views.profile.index');

        return view($view, compact(
            'user',
            'sessions',
        ));
    }
}
