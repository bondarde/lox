<?php

namespace BondarDe\Lox\Console\Commands;

use App\Models\User;
use BezhanSalleh\FilamentShield\Commands\GenerateCommand;
use BondarDe\Lox\Models\User as LoxUser;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class UpdateAclCommand extends Command
{
    protected $signature = 'lox:update-acl {--super-admin= : Super Admin’s user ID or e-mail }';
    protected $description = 'Updates ACL setup: permissions, super admin, …';

    public function handle(): void
    {
        $this->output->writeln('Updating permissions …');

        // generate permissions
        $this->call(GenerateCommand::class, [
            '--panel' => 'admin',
            '--all' => true,
            '--option' => 'permissions',
        ]);

        // create permissions for LOX
        $permission = Permission::query()->firstOrCreate([
            'name' => 'panel_admin',
            'guard_name' => 'web',
        ]);

        // assign "panel_admin", if "--super-admin" set
        $superAdminUserId = $this->option('super-admin');
        if ($superAdminUserId) {
            $this->output->writeln('Assigning permission "panel_admin" to user [' . $superAdminUserId . ']' . ' …');

            $user = User::query()->where(
                is_numeric($superAdminUserId)
                    ? [
                        LoxUser::FIELD_ID => $superAdminUserId,
                    ] : [
                        LoxUser::FIELD_EMAIL => $superAdminUserId,
                    ],
            )->sole();

            $user->permissions()->sync($permission->id, detaching: false);
        }

        $this->output->success('Done.');
    }
}
