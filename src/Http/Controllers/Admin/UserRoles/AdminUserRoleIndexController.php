<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

class AdminUserRoleIndexController
{
    public function __invoke()
    {
        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-roles.index');
    }
}