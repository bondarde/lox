<?php

namespace BondarDe\Lox\Data\Acl;

abstract class AclSetupData
{
    public const ROLE_SUPER_ADMIN = 'super-admin';
    public const PERMISSION_VIEW_MODEL_META_DATA = 'view model meta data';
    public const PERMISSION_VIEW_USERS = 'view users';
    public const PERMISSION_EDIT_USERS = 'edit users';
    public const PERMISSION_EDIT_CMS_PAGES = 'edit cms pages';
    public const PERMISSION_VIEW_SYSTEM_STATUS = 'view system status';

    public function __construct(
        public readonly string $name,
        public readonly string $guard,
    )
    {
    }
}
