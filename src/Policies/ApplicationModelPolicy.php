<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\Sushi\ApplicationModel;
use BondarDe\Lox\Models\User;

class ApplicationModelPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_application-model');
    }

    public function view(User $user, ApplicationModel $applicationModel): bool
    {
        return $user->hasPermissionTo('view_application-model');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_application-model');
    }

    public function update(User $user, ApplicationModel $applicationModel): bool
    {
        return $user->hasPermissionTo('update_application-model');
    }

    public function delete(User $user, ApplicationModel $applicationModel): bool
    {
        return $user->hasPermissionTo('delete_application-model');
    }

    public function restore(User $user, ApplicationModel $applicationModel): bool
    {
        return $user->hasPermissionTo('restore_application-model');
    }

    public function forceDelete(User $user, ApplicationModel $applicationModel): bool
    {
        return $user->hasPermissionTo('force_delete_application-model');
    }
}
