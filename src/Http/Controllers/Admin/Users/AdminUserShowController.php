<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Users;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

class AdminUserShowController
{
    public function __invoke(int $userId)
    {
        $userModel = config('auth.providers.users.model');
        $user = $userModel::query()->findOrFail($userId);

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.users.show', compact(
            'user',
        ));
    }
}
