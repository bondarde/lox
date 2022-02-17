<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Services\UserService;
use Illuminate\Http\Request;

class LogoutOtherBrowserSessionsController
{
    public function __invoke(Request $request, UserService $userService)
    {
        $userService->deleteOtherSessionRecords($request->user(), $request->session()->getId());

        return redirect(route('profile.show'))
            ->with('success-message', __('Other sessions have been terminated'));
    }
}
