<?php

namespace BondarDe\LaravelToolbox\Console\Commands\Acl;

use BondarDe\LaravelToolbox\Models\User;
use BondarDe\LaravelToolbox\Services\UserService;
use Illuminate\Console\Command;

class AclMakeAdminCommand extends Command
{
    protected $signature = 'acl:make-admin {idOrEmail}';
    protected $description = 'Assign admin privileges to the user with provided ID or e-mail';

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function handle(): int
    {
        $user = $this->getUser();

        if (is_null($user)) {
            $this->output->writeln('User not found. Please provide a valid ID or e-mail address.');

            return self::INVALID;
        }

        $user->assignGroup('admin');

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
