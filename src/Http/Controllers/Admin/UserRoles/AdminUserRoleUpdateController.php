<?php

namespace BondarDe\Lox\Http\Controllers\Admin\UserRoles;

use BondarDe\Lox\Http\Requests\Admin\Users\AdminUserRoleUpdateRequest;
use Spatie\Permission\Models\Role;

class AdminUserRoleUpdateController
{
    public function __invoke(
        Role                       $role,
        AdminUserRoleUpdateRequest $request,
    )
    {
        $attributes = $request->validated();

        $role->update($attributes);
        $role->permissions()->sync($attributes['permissions'] ?? []);

        return to_route('admin.user-roles.show', $role)
            ->with('success-message', __('Role has been updated.'));
    }
}
