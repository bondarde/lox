<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Users;

use App\Models\User;
use BondarDe\Lox\Http\Requests\Admin\Users\UserUpdateRequest;
use BondarDe\Lox\Services\UserService;

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
            $request->get(User::REL_ROLES, []),
            $request->get(User::REL_PERMISSIONS, []),
        );

        return redirect(route('admin.users.show', $user))
            ->with('success-message', __('User has been updated.'));
    }
}
