<?php

namespace BondarDe\LaravelToolbox\Data\Acl;

class AclSetupPermission extends AclSetupData
{
    public function __construct(
        public readonly string $name,
        public readonly string $guard,
        public readonly array  $roleNames = [],
    )
    {
    }
}
