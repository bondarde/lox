<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use BondarDe\LaravelToolbox\Services\AclService;
use Spatie\Permission\Models\Role;

class AdminUserRoleEditController
{
    public function __invoke(
        Role       $role,
        AclService $aclService,
    )
    {
        $availablePermissions = $aclService->permissions()->pluck('name', 'id')->toArray();
        $activePermissions = $role->permissions->pluck('id')->toArray();

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-roles.edit', compact(
            'role',
            'availablePermissions',
            'activePermissions',
        ));
    }
}
