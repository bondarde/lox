<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\User;

class CmsPagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_cms-page');
    }

    public function view(User $user, CmsPage $cmsPage): bool
    {
        return $user->hasPermissionTo('view_cms-page');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_cms-page');
    }

    public function update(User $user, CmsPage $cmsPage): bool
    {
        return $user->hasPermissionTo('update_cms-page');
    }

    public function delete(User $user, CmsPage $cmsPage): bool
    {
        return $user->hasPermissionTo('delete_cms-page');
    }

    public function restore(User $user, CmsPage $cmsPage): bool
    {
        return $user->hasPermissionTo('restore_cms-page');
    }

    public function forceDelete(User $user, CmsPage $cmsPage): bool
    {
        return $user->hasPermissionTo('force_delete_cms-page');
    }
}
