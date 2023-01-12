<?php

namespace BondarDe\LaravelToolbox\Models;

use BondarDe\LaravelToolbox\Constants\ModelCastTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    const FIELD_NAME = 'name';
    const FIELD_EMAIL = 'email';
    const FIELD_PASSWORD = 'password';
    const FIELD_REMEMBER_TOKEN = 'remember_token';
    const FIELD_TWO_FACTOR_SECRET = 'two_factor_secret';
    const FIELD_TWO_FACTOR_RECOVERY_CODES = 'two_factor_recovery_codes';
    const FIELD_EMAIL_VERIFIED_AT = 'email_verified_at';

    const ATTRIBUTE_ROLES = 'roles';
    const ATTRIBUTE_PERMISSIONS = 'permissions';


    protected $perPage = 100;

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
    ];
    protected $hidden = [
        self::FIELD_PASSWORD,
        self::FIELD_REMEMBER_TOKEN,
    ];
    protected $casts = [
        self::FIELD_EMAIL_VERIFIED_AT => ModelCastTypes::DATETIME,
    ];

    public static function findOrCreateUserForSocialProvider($provider, $id, $email, $name)
    {
        $providerIdColumn = 'social_' . $provider . '_id';

        // find a user for given social provider
        $user = \App\Models\User::query()
            ->where($providerIdColumn, $id)
            ->first();

        return $user ?? self::updateOrCreateSocialUser($id, $email, $name, $providerIdColumn);
    }

    private static function updateOrCreateSocialUser($id, $email, $name, string $providerIdColumn)
    {
        // find user by e-mail
        $user = User::query()
            ->where(self::FIELD_EMAIL, $email)
            ->first();

        if ($user == null) {
            // create & return new user
            return User::query()
                ->create([
                    self::FIELD_EMAIL => $email,
                    self::FIELD_NAME => $name,
                    self::FIELD_PASSWORD => Hash::make(Str::random(60)),
                    $providerIdColumn => $id,
                ]);
        }


        // update name if not yet set
        if (!$user->{self::FIELD_NAME}) {
            $user->{self::FIELD_NAME} = $name;
        }
        // save social id
        $user->$providerIdColumn = $id;

        $user->save();

        return $user;
    }
}
