<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Users;

use BondarDe\LaravelToolbox\Http\Requests\Admin\Users\UserUpdateRequest;
use BondarDe\LaravelToolbox\Models\User;
use BondarDe\LaravelToolbox\Services\UserService;

class AdminUserUpdateController
{
    public function __invoke(User $user, UserUpdateRequest $request, UserService $userService)
    {
        $userService->update(
            $user,
            $request->validated(),
            $request->get('groups', []),
            $request->get('permissions', []),
        );

        return redirect(route('admin.users.show', $user))
            ->with('success-message', __('User has been updated.'));
    }
}
