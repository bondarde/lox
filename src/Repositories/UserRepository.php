<?php

namespace BondarDe\LaravelToolbox\Repositories;

use App\Models\User as ApplicationUser;
use BondarDe\LaravelToolbox\Database\ModelRepository;
use BondarDe\LaravelToolbox\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends ModelRepository
{
    public function model(): string
    {
        return ApplicationUser::class;
    }

    public function findOrCreateUserForSsoProvider($provider, $id, $email, $name)
    {
        $ssoColumnPrefix = config('laravel-toolbox.sso.column_prefix');
        $ssoIdColumnName = $ssoColumnPrefix . '_' . $provider . '_id';

        // find a user for given SSO provider
        $user = $this->query()
            ->where($ssoIdColumnName, $id)
            ->first();

        return $user ?? $this->updateOrCreateSsoUser($id, $email, $name, $ssoIdColumnName);
    }

    private function updateOrCreateSsoUser($id, $email, $name, string $ssoIdColumnName)
    {
        // find user by e-mail
        $user = $this->query()
            ->where(User::FIELD_EMAIL, $email)
            ->first();

        if ($user == null) {
            // create & return new user
            return $this->create([
                User::FIELD_EMAIL => $email,
                User::FIELD_NAME => $name,
                User::FIELD_PASSWORD => Hash::make(Str::random(60)),
                $ssoIdColumnName => $id,
            ]);
        }


        // update name if not yet set
        if (!$user->{User::FIELD_NAME}) {
            $user->{User::FIELD_NAME} = $name;
        }
        // save SSO ID
        $user->$ssoIdColumnName = $id;

        $user->save();

        return $user;
    }
}
