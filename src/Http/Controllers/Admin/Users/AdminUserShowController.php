<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Users;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use BondarDe\LaravelToolbox\Models\User;

class AdminUserShowController
{
    public function __invoke(User $user)
    {
        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.users.show', compact(
            'user',
        ));
    }
}
