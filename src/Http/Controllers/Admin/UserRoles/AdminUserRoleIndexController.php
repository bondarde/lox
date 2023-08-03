<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserRoles;

use BondarDe\Lox\LoxServiceProvider;

class AdminUserRoleIndexController
{
    public function __invoke()
    {
        return view(LoxServiceProvider::NAMESPACE . '::admin.user-roles.index');
    }
}
