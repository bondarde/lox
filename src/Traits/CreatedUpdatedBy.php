<?php

namespace BondarDe\Lox\Traits;

use BondarDe\Lox\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
    const FIELD_CREATED_BY = 'created_by';
    const FIELD_UPDATED_BY = 'updated_by';

    const PROPERTY_CREATOR = 'creator';
    const PROPERTY_LAST_EDITOR = 'last_editor';

    protected static function bootCreatedUpdatedBy(): void
    {
        static::creating(function (Model $model) {
            if (!$model->isDirty(self::FIELD_CREATED_BY)) {
                $model->{self::FIELD_CREATED_BY} = Auth::user()?->{User::FIELD_ID};
            }
            if (!$model->isDirty(self::FIELD_UPDATED_BY)) {
                $model->{self::FIELD_UPDATED_BY} = Auth::user()?->{User::FIELD_ID};
            }
        });

        static::updating(function (Model $model) {
            if (!$model->isDirty(self::FIELD_UPDATED_BY)) {
                $model->{self::FIELD_UPDATED_BY} = Auth::user()?->{User::FIELD_ID};
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, self::FIELD_CREATED_BY);
    }

    public function last_editor(): BelongsTo
    {
        return $this->belongsTo(User::class, self::FIELD_UPDATED_BY);
    }
}
