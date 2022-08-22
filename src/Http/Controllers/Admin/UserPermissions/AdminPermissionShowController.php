<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserPermissions;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Spatie\Permission\Models\Permission;

class AdminPermissionShowController
{
    public function __invoke(Permission $permission)
    {
        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-permissions.show', compact(
            'permission',
        ));
    }
}
