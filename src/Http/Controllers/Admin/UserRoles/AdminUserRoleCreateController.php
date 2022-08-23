<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use BondarDe\LaravelToolbox\Services\AclService;

class AdminUserRoleCreateController
{
    public function __invoke(
        AclService $aclService,
    )
    {
        $availablePermissions = $aclService->permissions()->pluck('name', 'id')->toArray();
        $activePermissions = [];

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-roles.create', compact(
            'availablePermissions',
            'activePermissions',
        ));
    }
}
