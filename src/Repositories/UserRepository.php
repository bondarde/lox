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
    ) {
        $user = $this->query()
            ->whereRelation(User::REL_SSO_IDENTIFIERS, SsoIdentifier::FIELD_PROVIDER_NAME, $providerName)
            ->whereRelation(User::REL_SSO_IDENTIFIERS, SsoIdentifier::FIELD_PROVIDER_ID, $providerId)
            ->first();

        return $user ?? $this->updateOrCreateSsoUser($providerName, $providerId, $email, $name);
    }

    private function updateOrCreateSsoUser(
        string $providerName,
        string $providerId,
        string $email,
        ?string $name,
    ) {
        // find user by e-mail
        $user = $this->query()
            ->where(User::FIELD_EMAIL, $email)
            ->first();

        if (! $user) {
            // create new user
            /** @var User $user */
            $user = $this->create([
                User::FIELD_EMAIL => $email,
                User::FIELD_NAME => $name,
                User::FIELD_PASSWORD => Hash::make(Str::random(60)),
            ]);

            $user->sso_identifiers()->create([
                SsoIdentifier::FIELD_PROVIDER_NAME => $providerName,
                SsoIdentifier::FIELD_PROVIDER_ID => $providerId,
            ]);
        } else {
            // update name if not yet set
            if ($name && ! $user->{User::FIELD_NAME}) {
                $user->update([
                    User::FIELD_NAME => $name,
                ]);
            }
        }

        return $user;
    }
}
