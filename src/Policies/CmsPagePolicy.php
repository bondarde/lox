<?php

namespace BondarDe\Lox\Policies;

use BondarDe\Lox\Data\Acl\AclSetupData;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\User;

class CmsPagePolicy
{
    public function update(?User $user, CmsPage $cmsPage): bool
    {
        return $user?->hasPermissionTo(AclSetupData::PERMISSION_EDIT_CMS_PAGES);
    }
}
