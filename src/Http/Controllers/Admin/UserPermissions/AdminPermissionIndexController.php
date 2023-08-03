<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserPermissions;

use BondarDe\Lox\LoxServiceProvider;

class AdminPermissionIndexController
{
    public function __invoke()
    {
        return view(LoxServiceProvider::NAMESPACE . '::admin.user-permissions.index');
    }
}
