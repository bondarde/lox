<?php

namespace BondarDe\Lox\Repositories;

use App\Models\User as ApplicationUser;
use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\SsoIdentifier;
use BondarDe\Lox\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends ModelRepository
{
    public function model(): string
    {
        return ApplicationUser::class;
    }

    public function findOrCreateUserForSsoProvider(
        string $providerName,
        string $providerId,
        string $email,
        ?string $name = null,
        ?array $providerData = null,
    ) {
        $user = $this->query()
            ->whereRelation(User::REL_SSO_IDENTIFIERS, SsoIdentifier::FIELD_PROVIDER_NAME, $providerName)
            ->whereRelation(User::REL_SSO_IDENTIFIERS, SsoIdentifier::FIELD_PROVIDER_ID, $providerId)
            ->first();

        return $user ?? $this->updateOrCreateSsoUser($providerName, $providerId, $email, $name, $providerData);
    }

    private function updateOrCreateSsoUser(
        string $providerName,
        string $providerId,
        string $email,
        ?string $name,
        ?array $providerData,
    ) {
        // find user by e-mail
        $user = $this->query()
            ->firstOrCreate([
                User::FIELD_EMAIL => $email,
            ], [
                User::FIELD_NAME => $name,
                User::FIELD_PASSWORD => Hash::make(Str::random(60)),
            ]);

        if (! $user->wasRecentlyCreated && ! $user->{User::FIELD_NAME} && $name) {
            // update name if not yet set
            $user->update([
                User::FIELD_NAME => $name,
            ]);
        }

        $user->sso_identifiers()->firstOrCreate([
            SsoIdentifier::FIELD_PROVIDER_NAME => $providerName,
            SsoIdentifier::FIELD_PROVIDER_ID => $providerId,
            SsoIdentifier::FIELD_PROVIDER_DATA => $providerData,
        ]);

        return $user;
    }
}
