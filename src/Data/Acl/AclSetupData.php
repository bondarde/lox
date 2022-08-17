<?php

namespace BondarDe\LaravelToolbox\Data\Acl;

abstract class AclSetupData
{
    public const ROLE_SUPER_ADMIN = 'super-admin';
    public const PERMISSION_VIEW_MODEL_META_DATA = 'view model meta data';

    public function __construct(
        public readonly string $name,
        public readonly string $guard,
    )
    {
    }
}
