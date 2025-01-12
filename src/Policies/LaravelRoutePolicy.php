<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\User;
use Spatie\Permission\Models\Permission;

class LaravelRoutePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_permission');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('view_permission');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_permission');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('update_permission');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('delete_permission');
    }

    public function restore(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('restore_permission');
    }

    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('force_delete_permission');
    }
}
