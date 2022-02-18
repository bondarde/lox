<?php

namespace BondarDe\LaravelToolbox\Console\Commands\Acl;

use BondarDe\LaravelToolbox\Contracts\Acl\IsAclConfig;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupGroup;
use BondarDe\LaravelToolbox\Data\Acl\AclSetupPermission;
use BondarDe\LaravelToolbox\Services\AclService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Junges\ACL\Console\Commands\CreateGroup;
use Junges\ACL\Console\Commands\CreatePermission;
use Junges\ACL\Exceptions\GroupAlreadyExistsException;
use Junges\ACL\Exceptions\PermissionAlreadyExistsException;

class AclUpdateGroupsAndPermissionsCommand extends Command
{
    protected $signature = 'acl:update-groups-and-permission';
    protected $description = 'Updates groups and privileges to make them available';

    private AclService $aclService;

    public function __construct(AclService $aclService)
    {
        parent::__construct();
        $this->aclService = $aclService;
    }

    public function handle(): int
    {
        $basicConfig = $this->basicAclConfig();
        $config = config('laravel-toolbox.acl_config');

        $groups = $basicConfig->groups();
        $permissions = $basicConfig->permissions();

        if (!is_null($config)) {
            if (!is_subclass_of($config, IsAclConfig::class)) {
                $message = 'ACL config has to implement "' . IsAclConfig::class . '"';
                throw new Exception($message);
            }

            $config = new $config;

            $groups = $groups->merge($config->groups());
            $permissions = $permissions->merge($config->permissions());
        }

        $this->setupGroups($groups);
        $this->setupGroupPermissions($permissions);

        return self::SUCCESS;
    }

    private function basicAclConfig(): IsAclConfig
    {
        return new class implements IsAclConfig {
            const GROUP_ADMIN = 'admin';

            const PERMISSION_MODEL_VIEW_META = 'model:view-meta';

            public function groups(): Collection
            {
                return collect([
                    new AclSetupGroup('Admins', self::GROUP_ADMIN, 'Admin users group'),
                ]);
            }

            public function permissions(): Collection
            {
                return collect([
                    new AclSetupPermission('Model: meta', self::PERMISSION_MODEL_VIEW_META, 'View models meta data'),
                ]);
            }
        };
    }

    private function setupGroups(Collection $groups)
    {
        $groups->each(function (AclSetupGroup $group) {
            $this->line('Creating group "' . $group->slug . '"…');

            try {
                Artisan::call(
                    CreateGroup::class,
                    [
                        'name' => $group->name,
                        'slug' => $group->slug,
                        'description' => $group->description,
                    ],
                    $this->getOutput(),
                );
            } catch (GroupAlreadyExistsException $e) {
            }
        });
    }

    private function setupGroupPermissions(Collection $permissions)
    {
        $permissions->each(function (AclSetupPermission $permission) {
            $this->line('Creating permission "' . $permission->slug . '"…');

            try {
                Artisan::call(
                    CreatePermission::class,
                    [
                        'name' => $permission->name,
                        'slug' => $permission->slug,
                        'description' => $permission->description,
                    ],
                    $this->getOutput(),
                );
            } catch (PermissionAlreadyExistsException $e) {
            }

            foreach ($permission->groupSlugs as $groupSlug) {
                $this->line('Assigning permission "' . $permission->slug . '" to group "' . $groupSlug . '"…');

                $this->aclService->findGroupBySlugOrFail($groupSlug)
                    ->assignPermissions($permission->slug);

                $this->line('Done.');
            }
        });
    }
}
