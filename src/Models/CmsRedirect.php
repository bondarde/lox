<?php

namespace BondarDe\Lox\Models;

use Illuminate\Database\Eloquent\Model;

class CmsRedirect extends Model
{
    const string FIELD_ID = 'id';
    const string FIELD_PATH = 'path';
    const string FIELD_TARGET = 'target';

    protected $fillable = [
        self::FIELD_PATH,
        self::FIELD_TARGET,
    ];
}
