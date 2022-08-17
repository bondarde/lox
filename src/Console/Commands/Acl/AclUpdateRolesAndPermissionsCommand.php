<?php

namespace BondarDe\LaravelToolbox\Console\Commands\Acl;

use BondarDe\LaravelToolbox\Contracts\Acl\IsAclConfig;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupData;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupPermission;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupRole;
use BondarDe\LaravelToolbox\Services\AclService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class AclUpdateRolesAndPermissionsCommand extends Command
{
    protected $signature = 'acl:update-roles-and-permission';
    protected $description = 'Updates roles and permissions list';

    private Collection $roles;
    private Collection $permissions;

    public function __construct(
        private readonly AclService $aclService,
    )
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $basicConfig = $this->basicAclConfig();

        $this->roles = $basicConfig->roles();
        $this->permissions = $basicConfig->permissions();

        $this->extendRolesAndPermissionsList();
        $this->setupRoles($this->roles);
        $this->setupRolePermissions($this->permissions);

        return self::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function extendRolesAndPermissionsList()
    {
        $config = config('laravel-toolbox.acl_config');

        if (is_null($config)) {
            return;
        }

        if (!is_subclass_of($config, IsAclConfig::class)) {
            $message = 'ACL config has to implement "' . IsAclConfig::class . '"';
            throw new Exception($message);
        }

        $config = new $config;

        $this->roles = $this->roles->merge($config->roles());
        $this->permissions = $this->permissions->merge($config->permissions());
    }

    private function basicAclConfig(): IsAclConfig
    {
        return new class implements IsAclConfig {
            public function roles(): Collection
            {
                return collect([
                    new AclSetupRole(AclSetupData::ROLE_SUPER_ADMIN, 'web'),
                ]);
            }

            public function permissions(): Collection
            {
                return collect([
                    new AclSetupPermission(AclSetupData::PERMISSION_VIEW_MODEL_META_DATA, 'web'),
                ]);
            }
        };
    }

    private function setupRoles(Collection $roles)
    {
        $roles->each(function (AclSetupRole $roleSetup) {
            $this->line('Creating/updating role "' . $roleSetup->name . '"…');

            $role = $this->aclService->updateOrCreateRole($roleSetup);

            if ($role->wasRecentlyCreated) {
                $this->info('Created.');
            } else {
                $this->line('Updated.');
            }
        });
    }

    private function setupRolePermissions(Collection $permissions)
    {
        $permissions->each(function (AclSetupPermission $permissionSetup) {
            $this->line('Creating/updating permission "' . $permissionSetup->name . '"…');

            $permission = $this->aclService->updateOrCreatePermission($permissionSetup);

            if ($permission->wasRecentlyCreated) {
                $this->info('Created.');
            } else {
                $this->line('Updated.');
            }

            foreach ($permissionSetup->roleNames as $roleName) {
                $this->line('Assigning permission "' . $permissionSetup->name . '" to role "' . $roleName . '"…');

                $this->aclService->findRoleByNameAndGuardOrFail($roleName, $permissionSetup->guard)
                    ->givePermissionTo($permissionSetup->name);

                $this->info('Roles assignment done.');
            }
        });
    }
}
