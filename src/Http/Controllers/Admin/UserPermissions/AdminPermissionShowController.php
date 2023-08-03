<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserPermissions;

use BondarDe\Lox\LoxServiceProvider;
use Spatie\Permission\Models\Permission;

class AdminPermissionShowController
{
    public function __invoke(Permission $permission)
    {
        return view(LoxServiceProvider::NAMESPACE . '::admin.user-permissions.show', compact(
            'permission',
        ));
    }
}
