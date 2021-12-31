<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use BondarDe\LaravelToolbox\Http\Requests\User\Profile\UserProfileUpdateRequest;

class UserProfileUpdateController
{
    public function __invoke(UserProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        return redirect(route('profile.show'))
            ->with('success-message', __('Profile updated'));
    }
}
