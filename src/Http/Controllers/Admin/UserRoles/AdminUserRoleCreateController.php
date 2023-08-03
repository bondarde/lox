<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserRoles;

use BondarDe\Lox\LoxServiceProvider;
use BondarDe\Lox\Services\AclService;

class AdminUserRoleCreateController
{
    public function __invoke(
        AclService $aclService,
    )
    {
        $availablePermissions = $aclService->permissions()->pluck('name', 'id')->toArray();
        $activePermissions = [];

        return view(LoxServiceProvider::NAMESPACE . '::admin.user-roles.create', compact(
            'availablePermissions',
            'activePermissions',
        ));
    }
}
