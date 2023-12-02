<?php

namespace BondarDe\Lox\Models;

use Illuminate\Database\Eloquent\Model;

class CmsRedirect extends Model
{
    const FIELD_ID = 'id';
    const FIELD_PATH = 'path';
    const FIELD_TARGET = 'target';

    protected $fillable = [
        self::FIELD_PATH,
        self::FIELD_TARGET,
    ];
}
