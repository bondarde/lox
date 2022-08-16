<?php

namespace BondarDe\LaravelToolbox\Services;

use BondarDe\LaravelToolbox\Data\Acl\AclSetupGroup;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupPermission;
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

    public function findGroupByNameAndGuardOrFail(
        string $name,
        string $guard,
    ): Group
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Group::query()
            ->where('name', $name)
            ->where('guard_name', $guard)
            ->sole();
    }

    public function updateOrCreateGroup(AclSetupGroup $group): Group
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Group::query()->updateOrCreate([
            'name' => $group->name,
            'guard_name' => $group->guard,
        ], [
            'description' => $group->description,
        ]);
    }

    public function updateOrCreatePermission(AclSetupPermission $permission): Permission
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Permission::query()->updateOrCreate([
            'name' => $permission->name,
            'guard_name' => $permission->guard,
        ], [
            'description' => $permission->description,
        ]);
    }
}
