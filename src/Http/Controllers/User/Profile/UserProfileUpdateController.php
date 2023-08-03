<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Http\Requests\User\Profile\UserProfileUpdateRequest;

class UserProfileUpdateController
{
    public function __invoke(UserProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        return redirect(route('user.index'))
            ->with('success-message', __('Profile updated'));
    }
}
