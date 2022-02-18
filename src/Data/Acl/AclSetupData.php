<?php

namespace BondarDe\LaravelToolbox\Data\Acl;

abstract class AclSetupData
{
    public string $name;
    public string $slug;
    public string $description;

    public function __construct(string $name, string $slug, string $description)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
    }
}
