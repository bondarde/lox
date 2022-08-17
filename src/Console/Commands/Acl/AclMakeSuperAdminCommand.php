<?php

namespace BondarDe\LaravelToolbox\Console\Commands\Acl;

use App\Models\User;
use BondarDe\LaravelToolbox\Services\UserService;
use Illuminate\Console\Command;

class AclMakeSuperAdminCommand extends Command
{
    protected $signature = 'acl:make-super-admin {idOrEmail}';
    protected $description = 'Assign super-admin privileges to the user with provided ID or e-mail';

    public function __construct(
        private readonly UserService $userService,
    )
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $user = $this->getUser();

        if (is_null($user)) {
            $this->output->writeln('User not found. Please provide a valid ID or e-mail address.');

            return self::INVALID;
        }

        $user->assignRole('super-admin');

        $this->info('User "' . $user->{User::FIELD_NAME} . ' (' . $user->{User::FIELD_EMAIL} . ')" has been assigned to "super-admin" role.');

        return self::SUCCESS;
    }

    private function getUser(): ?User
    {
        $idOrEmail = $this->argument('idOrEmail');

        if (filter_var($idOrEmail, FILTER_VALIDATE_EMAIL) !== false) {
            return $this->userService->findByEmail($idOrEmail);
        } else if (is_numeric($idOrEmail)) {
            return $this->userService->findById(intval($idOrEmail));
        }

        return null;
    }
}
