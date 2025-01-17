<?php

namespace BondarDe\Lox\Console\Commands;

use App\Models\User;
use BondarDe\Lox\Models\SsoIdentifier;
use Illuminate\Console\Command;

class MigrateSsoIdentifiersCommand extends Command
{
    protected $signature = 'lox:migrate-sso-identifiers';
    protected $description = 'Migrates SSO identifiers (v2 -> v3)';

    public function handle(): void
    {
        $ssoColumnPrefix = config('lox.sso.column_prefix');
        $providers = config('fortify-options.sso', []);

        foreach ($providers as $provider => $_) {
            $this->output->writeln('Migrating ' . $provider . ' …');

            $ssoIdColumnName = $ssoColumnPrefix . '_' . $provider . '_id';
            $users = User::query()
                ->whereNotNull($ssoIdColumnName)
                ->get();

            $users->each(function (User $user) use ($ssoIdColumnName, $provider) {
                $user->sso_identifiers()->create([
                    SsoIdentifier::FIELD_PROVIDER_NAME => $provider,
                    SsoIdentifier::FIELD_PROVIDER_ID => $user->$ssoIdColumnName,
                ]);
            });
        }

        $this->output->success('Done.');
    }
}
