<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Services\UsersService;
use BondarDe\LaravelToolbox\Http\Requests\User\Profile\AccountDeleteRequest;

class DeleteAccountDeleteController
{
    public function __invoke(AccountDeleteRequest $request)
    {
        UsersService::delete($request->user());

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect(route('home'))
            ->with('success-message', __('Your account has been deleted'));
    }
}
