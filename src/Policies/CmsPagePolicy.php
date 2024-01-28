<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Data\Acl\AclSetupData;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\User;

class CmsPagePolicy
{
    public function view(User $user, CmsPage $cmsPage): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(?User $user, CmsPage $cmsPage): bool
    {
        return $user?->hasPermissionTo(AclSetupData::PERMISSION_EDIT_CMS_PAGES) ?: false;
    }

    public function delete(User $user, CmsPage $cmsPage): bool
    {
        return false;
    }

    public function restore(User $user, CmsPage $cmsPage): bool
    {
        return false;
    }

    public function forceDelete(User $user, CmsPage $cmsPage): bool
    {
        return false;
    }
}
