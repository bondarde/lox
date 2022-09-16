<?php

namespace BondarDe\LaravelToolbox\Services;

use BondarDe\LaravelToolbox\Data\Acl\AclSetupPermission;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupRole;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclService
{
    public function roles(): Collection
    {
        return Role::all()
            ->sortBy('name');
    }

    public function permissions(): Collection
    {
        return Permission::all()
            ->sort(function (Permission $a, Permission $b) {
                $nameA = $a->name;
                $nameB = $b->name;
                [$verbA, $entityA] = explode(' ', $nameA, 2);
                [$verbB, $entityB] = explode(' ', $nameB, 2);

                $res = strcmp($entityA, $entityB);

                return $res !== 0 ? $res : strcmp($verbA, $verbB);
            });
    }

    public function findRoleByNameAndGuardOrFail(
        string $name,
        string $guard,
    ): Role
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Role::query()
            ->where('name', $name)
            ->where('guard_name', $guard)
            ->sole();
    }

    public function updateOrCreateRole(AclSetupRole $role): Role
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Role::query()->updateOrCreate([
            'name' => $role->name,
            'guard_name' => $role->guard,
        ]);
    }

    public function updateOrCreatePermission(AclSetupPermission $permission): Permission
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Permission::query()->updateOrCreate([
            'name' => $permission->name,
            'guard_name' => $permission->guard,
        ]);
    }
}
