<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserRoles;

use BondarDe\Lox\LoxServiceProvider;
use BondarDe\Lox\Services\AclService;
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

        return view(LoxServiceProvider::NAMESPACE . '::admin.user-roles.edit', compact(
            'role',
            'availablePermissions',
            'activePermissions',
        ));
    }
}
