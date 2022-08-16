<?php

namespace BondarDe\LaravelToolbox\Console\Commands\Acl;

use BondarDe\LaravelToolbox\Contracts\Acl\IsAclConfig;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupGroup;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupPermission;
use BondarDe\LaravelToolbox\Services\AclService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class AclUpdateGroupsAndPermissionsCommand extends Command
{
    protected $signature = 'acl:update-groups-and-permission';
    protected $description = 'Updates groups and privileges to make them available';

    private Collection $groups;
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

        $this->groups = $basicConfig->groups();
        $this->permissions = $basicConfig->permissions();

        $this->extendGroupsAndPermissionsList();
        $this->setupGroups($this->groups);
        $this->setupGroupPermissions($this->permissions);

        return self::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function extendGroupsAndPermissionsList()
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

        $this->groups = $this->groups->merge($config->groups());
        $this->permissions = $this->permissions->merge($config->permissions());
    }

    private function basicAclConfig(): IsAclConfig
    {
        return new class implements IsAclConfig {
            const GROUP_ADMIN = 'admin';

            const PERMISSION_MODEL_VIEW_META = 'model:view-meta';

            public function groups(): Collection
            {
                return collect([
                    new AclSetupGroup(self::GROUP_ADMIN, 'Admins', 'web'),
                ]);
            }

            public function permissions(): Collection
            {
                return collect([
                    new AclSetupPermission(self::PERMISSION_MODEL_VIEW_META, 'View models meta data', 'web'),
                ]);
            }
        };
    }

    private function setupGroups(Collection $groups)
    {
        $groups->each(function (AclSetupGroup $groupSetup) {
            $this->line('Creating/updating group "' . $groupSetup->name . '"…');

            $group = $this->aclService->updateOrCreateGroup($groupSetup);

            if ($group->wasRecentlyCreated) {
                $this->info('Created.');
            } else {
                $this->line('Updated.');
            }
        });
    }

    private function setupGroupPermissions(Collection $permissions)
    {
        $permissions->each(function (AclSetupPermission $permissionSetup) {
            $this->line('Creating/updating permission "' . $permissionSetup->name . '"…');

            $permission = $this->aclService->updateOrCreatePermission($permissionSetup);

            if ($permission->wasRecentlyCreated) {
                $this->info('Created.');
            } else {
                $this->line('Updated.');
            }

            foreach ($permissionSetup->groupNames as $groupName) {
                $this->line('Assigning permission "' . $permissionSetup->name . '" to group "' . $groupName . '"…');

                $this->aclService->findGroupByNameAndGuardOrFail($groupName, $permissionSetup->guard)
                    ->assignPermission($permissionSetup->name);

                $this->info('Groups assignment done.');
            }
        });
    }
}
