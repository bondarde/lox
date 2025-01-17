<?php

namespace BondarDe\Lox\Models;

use BondarDe\Lox\Constants\ModelCastTypes;
use Illuminate\Database\Eloquent\Model;

class CmsAssistantTask extends Model
{
    const string FIELD_ID = 'id';
    const string FIELD_CREATED_AT = self::CREATED_AT;
    const string FIELD_UPDATED_AT = self::UPDATED_AT;

    const string FIELD_TASK = 'task';
    const string FIELD_TOPIC = 'topic';
    const string FIELD_LOCALE = 'locale';

    const string FIELD_EXECUTION_STARTED_AT = 'execution_started_at';
    const string FIELD_EXECUTION_FINISHED_AT = 'execution_finished_at';

    protected $fillable = [
        self::FIELD_TASK,
        self::FIELD_TOPIC,
        self::FIELD_LOCALE,
        self::FIELD_EXECUTION_STARTED_AT,
        self::FIELD_EXECUTION_FINISHED_AT,
    ];

    protected $casts = [
        self::FIELD_EXECUTION_STARTED_AT => ModelCastTypes::DATETIME,
        self::FIELD_EXECUTION_FINISHED_AT => ModelCastTypes::DATETIME,
    ];
}
