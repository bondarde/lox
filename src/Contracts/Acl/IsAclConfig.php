<?php

namespace BondarDe\Lox\Contracts\Acl;

use Illuminate\Support\Collection;

interface IsAclConfig
{
    public function roles(): Collection;

    public function permissions(): Collection;
}
