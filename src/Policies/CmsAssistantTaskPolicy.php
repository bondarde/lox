<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Models\CmsAssistantTask;
use BondarDe\Lox\Models\User;

class CmsAssistantTaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_cms-assistant-task');
    }

    public function view(User $user, CmsAssistantTask $cmsAssistantTask): bool
    {
        return $user->hasPermissionTo('view_cms-assistant-task');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_cms-assistant-task');
    }

    public function update(User $user, CmsAssistantTask $cmsAssistantTask): bool
    {
        return $user->hasPermissionTo('update_cms-assistant-task');
    }

    public function delete(User $user, CmsAssistantTask $cmsAssistantTask): bool
    {
        return $user->hasPermissionTo('delete_cms-assistant-task');
    }

    public function restore(User $user, CmsAssistantTask $cmsAssistantTask): bool
    {
        return $user->hasPermissionTo('restore_cms-assistant-task');
    }

    public function forceDelete(User $user, CmsAssistantTask $cmsAssistantTask): bool
    {
        return $user->hasPermissionTo('force_delete_cms-assistant-task');
    }
}
