<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Users;

use App\Models\User;
use BondarDe\Lox\LoxServiceProvider;
use BondarDe\Lox\Services\AclService;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserEditController
{
    public function __invoke(
        User       $user,
        AclService $aclService,
    )
    {
        $roles = $aclService->roles()
            ->sortBy('name')
            ->keyBy('id')
            ->map(fn(Role $role) => $role->name)
            ->toArray();
        $permissions = $aclService->permissions()
            ->sortBy('name')
            ->keyBy('id')
            ->map(fn(Permission $permission) => $permission->name)
            ->toArray();

        $activeRoles = $user->roles
            ->pluck('id')
            ->toArray();
        $activePermissions = $user->permissions
            ->pluck('id')
            ->toArray();


        return View::make(LoxServiceProvider::NAMESPACE . '::admin.users.edit', compact(
            'user',
            'roles',
            'permissions',
            'activeRoles',
            'activePermissions',
        ));
    }
}
