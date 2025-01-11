<?php

namespace BondarDe\Lox\Models;

use BondarDe\Lox\Constants\ModelCastTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SsoIdentifier extends Model
{
    const string FIELD_ID = 'id';
    const string FIELD_USER_ID = 'user_id';
    const string FIELD_PROVIDER_NAME = 'provider_name';
    const string FIELD_PROVIDER_ID = 'provider_id';
    const string FIELD_PROVIDER_DATA = 'provider_data';

    const string REL_USER = 'user';

    protected $fillable = [
        self::FIELD_USER_ID,
        self::FIELD_PROVIDER_NAME,
        self::FIELD_PROVIDER_ID,
        self::FIELD_PROVIDER_DATA,
    ];
    protected $casts = [
        self::FIELD_PROVIDER_DATA => ModelCastTypes::ARRAY,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
