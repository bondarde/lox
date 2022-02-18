<?php

namespace BondarDe\LaravelToolbox\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Junges\ACL\Concerns\UsersTrait;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use UsersTrait;

    const FIELD_NAME = 'name';
    const FIELD_EMAIL = 'email';
    const FIELD_PASSWORD = 'password';
    const FIELD_REMEMBER_TOKEN = 'remember_token';
    const FIELD_TWO_FACTOR_SECRET = 'two_factor_secret';
    const FIELD_TWO_FACTOR_RECOVERY_CODES = 'two_factor_recovery_codes';
    const FIELD_EMAIL_VERIFIED_AT = 'email_verified_at';


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
    ];
    protected $dates = [
        self::FIELD_EMAIL_VERIFIED_AT,
    ];
}
