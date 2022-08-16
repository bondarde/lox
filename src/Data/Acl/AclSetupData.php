<?php

namespace BondarDe\LaravelToolbox\Data\Acl;

abstract class AclSetupData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $guard,
    )
    {
    }
}
