<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Users;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use BondarDe\LaravelToolbox\Models\User;
use BondarDe\LaravelToolbox\Services\AclService;
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;
use View;

class AdminUserEditController
{
    public function __invoke(User $user, AclService $aclService)
    {
        $groups = $aclService->getGroups()
            ->sortBy('name')
            ->keyBy('id')
            ->map(fn(Group $group) => $group->name . ' (' . $group->description . ')')
            ->toArray();
        $permissions = $aclService->getPermissions()
            ->sortBy('name')
            ->keyBy('id')
            ->map(fn(Permission $permission) => $permission->name . ' (' . $permission->description . ')')
            ->toArray();

        $activeGroups = $user->groups
            ->pluck('id')
            ->toArray();
        $activePermissions = $user->permissions
            ->pluck('id')
            ->toArray();


        return View::first([
            'admin.users.edit',
            LaravelToolboxServiceProvider::NAMESPACE . '::admin.users.edit',
        ], compact(
            'user',
            'groups',
            'permissions',
            'activeGroups',
            'activePermissions',
        ));
    }
}
