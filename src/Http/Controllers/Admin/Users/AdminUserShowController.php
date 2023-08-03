<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Users;

use BondarDe\Lox\LoxServiceProvider;

class AdminUserShowController
{
    public function __invoke(int $userId)
    {
        $userModel = config('auth.providers.users.model');
        $user = $userModel::query()->findOrFail($userId);

        return view(LoxServiceProvider::NAMESPACE . '::admin.users.show', compact(
            'user',
        ));
    }
}
