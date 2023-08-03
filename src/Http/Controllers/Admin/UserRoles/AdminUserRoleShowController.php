<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserRoles;

use BondarDe\Lox\LoxServiceProvider;
use Spatie\Permission\Models\Role;

class AdminUserRoleShowController
{
    public function __invoke(Role $role)
    {
        return view(LoxServiceProvider::NAMESPACE . '::admin.user-roles.show', compact(
            'role',
        ));
    }
}
