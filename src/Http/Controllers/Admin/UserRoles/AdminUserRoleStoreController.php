<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles;

use BondarDe\LaravelToolbox\Constants\ValidationRules;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminUserRoleStoreController
{
    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            'name' => [
                ValidationRules::REQUIRED,
                ValidationRules::min(1),
            ],
            'guard_name' => [
                ValidationRules::REQUIRED,
                ValidationRules::min(3),
            ],
        ]);

        $role = Role::create($attributes);

        return to_route('admin.user-roles.show', $role)
            ->with('success-message', __('Role has been created.'));
    }
}
