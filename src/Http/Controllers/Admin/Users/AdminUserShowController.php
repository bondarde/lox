<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Users;

use App\Models\User;
use BondarDe\Lox\LoxServiceProvider;

class AdminUserShowController
{
    public function __invoke(User $user)
    {
        return view(LoxServiceProvider::NAMESPACE . '::admin.users.show', compact(
            'user',
        ));
    }
}
