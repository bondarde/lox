<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\CmsRedirect;
use BondarDe\Lox\Models\User;

class CmsRedirectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_cms-redirect');
    }

    public function view(User $user, CmsRedirect $cmsRedirect): bool
    {
        return $user->hasPermissionTo('view_cms-redirect');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_cms-redirect');
    }

    public function update(User $user, CmsRedirect $cmsRedirect): bool
    {
        return $user->hasPermissionTo('update_cms-redirect');
    }

    public function delete(User $user, CmsRedirect $cmsRedirect): bool
    {
        return $user->hasPermissionTo('delete_cms-redirect');
    }

    public function restore(User $user, CmsRedirect $cmsRedirect): bool
    {
        return $user->hasPermissionTo('restore_cms-redirect');
    }

    public function forceDelete(User $user, CmsRedirect $cmsRedirect): bool
    {
        return $user->hasPermissionTo('force_delete_cms-redirect');
    }
}
