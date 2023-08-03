<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Services\UserService;
use Illuminate\Http\Request;

class LogoutOtherBrowserSessionsController
{
    public function __invoke(Request $request, UserService $userService)
    {
        $userService->deleteOtherSessionRecords($request->user(), $request->session()->getId());

        return redirect(route('user.index'))
            ->with('success-message', __('Other sessions have been terminated'));
    }
}
