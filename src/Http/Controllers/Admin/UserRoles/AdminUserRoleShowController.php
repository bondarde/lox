<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Spatie\Permission\Models\Role;

class AdminUserRoleShowController
{
    public function __invoke(Role $role)
    {
        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-roles.show', compact(
            'role',
        ));
    }
}
