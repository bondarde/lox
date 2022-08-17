<?php

namespace BondarDe\LaravelToolbox\Contracts\Acl;

use Illuminate\Support\Collection;

interface IsAclConfig
{
    public function roles(): Collection;

    public function permissions(): Collection;
}
