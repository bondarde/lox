<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Services\UsersService;
use Illuminate\Http\Request;

class LogoutOtherBrowserSessionsController
{
    public function __invoke(Request $request)
    {
        UsersService::deleteOtherSessionRecords($request->user(), $request->session()->getId());

        return redirect(route('profile.show'))
            ->with('success-message', __('Other sessions have been terminated'));
    }
}
