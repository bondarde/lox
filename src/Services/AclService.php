<?php

namespace BondarDe\LaravelToolbox\Services;

use Illuminate\Support\Collection;
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;

class AclService
{
    public function getGroups(): Collection
    {
        return Group::query()->get();
    }

    public function getPermissions(): Collection
    {
        return Permission::query()->get();
    }

    public function findGroupBySlugOrFail(string $slug): Group
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Group::query()
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
