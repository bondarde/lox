<?php

namespace BondarDe\Lox\Models;

use BondarDe\Lox\Constants\ModelCastTypes;
use BondarDe\Lox\Livewire\ModelList\Concerns\WithConfigurableColumns;
use BondarDe\Lox\Models\Columns\UserColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements WithConfigurableColumns
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

    public static function getModelListColumnConfigurations(): ?string
    {
        return UserColumns::class;
    }
}
