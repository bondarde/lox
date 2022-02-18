<?php

namespace BondarDe\LaravelToolbox\Contracts\Acl;

use Illuminate\Support\Collection;

interface IsAclConfig
{
    public function groups(): Collection;

    public function permissions(): Collection;
}
