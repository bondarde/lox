<?php

namespace BondarDe\Lox\Traits;

use Illuminate\Support\Str;

trait GetsUuidOnCreation
{
    const FIELD_UUID = 'uuid';

    protected static function bootGetsUuidOnCreation(): void
    {
        static::creating(function (self $model) {
            $model->{self::FIELD_UUID} = Str::uuid();
        });
    }
}
