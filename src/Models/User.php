<?php

namespace BondarDe\Lox\Models;

use BondarDe\Lox\Constants\Acl\Role;
use BondarDe\Lox\Constants\ModelCastTypes;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const string FIELD_ID = 'id';
    const string FIELD_NAME = 'name';
    const string FIELD_EMAIL = 'email';
    const string FIELD_PASSWORD = 'password';
    const string FIELD_REMEMBER_TOKEN = 'remember_token';
    const string FIELD_TWO_FACTOR_SECRET = 'two_factor_secret';
    const string FIELD_TWO_FACTOR_RECOVERY_CODES = 'two_factor_recovery_codes';
    const string FIELD_EMAIL_VERIFIED_AT = 'email_verified_at';

    const string REL_ROLES = 'roles';
    const string REL_PERMISSIONS = 'permissions';
    const string REL_SSO_IDENTIFIERS = 'sso_identifiers';

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

    public function sso_identifiers(): HasMany
    {
        return $this->hasMany(SsoIdentifier::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(Role::SuperAdmin)
            || $this->hasPermissionTo('panel_' . $panel->getId());
    }
}
