<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\Sushi\DatabaseRelation;
use BondarDe\Lox\Models\User;

class DatabaseRelationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_database-relation');
    }

    public function view(User $user, DatabaseRelation $databaseRelation): bool
    {
        return $user->hasPermissionTo('view_database-relation');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_database-relation');
    }

    public function update(User $user, DatabaseRelation $databaseRelation): bool
    {
        return $user->hasPermissionTo('update_database-relation');
    }

    public function delete(User $user, DatabaseRelation $databaseRelation): bool
    {
        return $user->hasPermissionTo('delete_database-relation');
    }

    public function restore(User $user, DatabaseRelation $databaseRelation): bool
    {
        return $user->hasPermissionTo('restore_database-relation');
    }

    public function forceDelete(User $user, DatabaseRelation $databaseRelation): bool
    {
        return $user->hasPermissionTo('force_delete_database-relation');
    }
}
