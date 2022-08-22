<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Users;

use App\Models\User;
use BondarDe\LaravelToolbox\Http\Requests\Admin\Users\UserUpdateRequest;
use BondarDe\LaravelToolbox\Services\UserService;

class AdminUserUpdateController
{
    public function __invoke(
        User              $user,
        UserUpdateRequest $request,
        UserService       $userService,
    )
    {
        $userService->update(
            $user,
            $request->validated(),
            $request->get(User::ATTRIBUTE_ROLES, []),
            $request->get(User::ATTRIBUTE_PERMISSIONS, []),
        );

        return redirect(route('admin.users.show', $user))
            ->with('success-message', __('User has been updated.'));
    }
}
