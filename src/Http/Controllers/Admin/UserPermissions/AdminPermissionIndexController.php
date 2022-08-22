<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserPermissions;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

class AdminPermissionIndexController
{
    public function __invoke()
    {
        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-permissions.index');
    }
}
