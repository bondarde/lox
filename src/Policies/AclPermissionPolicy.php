<?php

namespace BondarDe\Lox\Policies;

use BondarDe\FilamentRouteList\Models\LaravelRoute;
use BondarDe\Lox\Models\User;
use Spatie\Permission\Models\Permission;

class AclPermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_laravel-route');
    }

    public function view(User $user, LaravelRoute $laravelRoute): bool
    {
        return $user->hasPermissionTo('view_laravel-route');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_laravel-route');
    }

    public function update(User $user, LaravelRoute $laravelRoute): bool
    {
        return $user->hasPermissionTo('update_laravel-route');
    }

    public function delete(User $user, LaravelRoute $laravelRoute): bool
    {
        return $user->hasPermissionTo('delete_laravel-route');
    }

    public function restore(User $user, LaravelRoute $laravelRoute): bool
    {
        return $user->hasPermissionTo('restore_laravel-route');
    }

    public function forceDelete(User $user, LaravelRoute $laravelRoute): bool
    {
        return $user->hasPermissionTo('force_delete_laravel-route');
    }
}
