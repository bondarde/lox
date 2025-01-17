<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\User;
use Spatie\Permission\Models\Role;

class AclRolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_role');
    }

    public function view(User $user, Role $Role): bool
    {
        return $user->hasPermissionTo('view_role');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_role');
    }

    public function update(User $user, Role $Role): bool
    {
        return $user->hasPermissionTo('update_role');
    }

    public function delete(User $user, Role $Role): bool
    {
        return $user->hasPermissionTo('delete_role');
    }

    public function restore(User $user, Role $Role): bool
    {
        return $user->hasPermissionTo('restore_role');
    }

    public function forceDelete(User $user, Role $Role): bool
    {
        return $user->hasPermissionTo('force_delete_role');
    }
}
