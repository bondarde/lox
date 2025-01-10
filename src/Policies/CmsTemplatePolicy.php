<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\User;

class CmsTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_cms-template');
    }

    public function view(User $user, CmsTemplate $cmsTemplate): bool
    {
        return $user->hasPermissionTo('view_cms-template');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_cms-template');
    }

    public function update(User $user, CmsTemplate $cmsTemplate): bool
    {
        return $user->hasPermissionTo('update_cms-template');
    }

    public function delete(User $user, CmsTemplate $cmsTemplate): bool
    {
        return $user->hasPermissionTo('delete_cms-template');
    }

    public function restore(User $user, CmsTemplate $cmsTemplate): bool
    {
        return $user->hasPermissionTo('restore_cms-template');
    }

    public function forceDelete(User $user, CmsTemplate $cmsTemplate): bool
    {
        return $user->hasPermissionTo('force_delete_cms-template');
    }
}
