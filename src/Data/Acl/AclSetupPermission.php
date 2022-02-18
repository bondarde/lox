<?php

namespace BondarDe\LaravelToolbox\Data\Acl;

class AclSetupPermission extends AclSetupData
{
    public array $groupSlugs;

    public function __construct(
        string $name,
        string $slug,
        string $description,
        array  $groupSlugs = []
    )
    {
        parent::__construct($name, $slug, $description);

        $this->groupSlugs = $groupSlugs;
    }
}
