<?php

namespace BondarDe\LaravelToolbox\Constants;

abstract class  ValidationRules
{
    const REQUIRED = 'required';
    const OPTIONAL = 'nullable';
    const STOP_ON_FIRST_ERROR = 'bail';

    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'int';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY = 'array';
    const TYPE_DATE = 'date';

    const DATE_YESTERDAY = 'yesterday';
    const DATE_TODAY = 'today';
    const DATE_TOMORROW = 'tomorrow';

    public static function min(int $val): string
    {
        return 'min:' . $val;
    }

    public static function max(int $val): string
    {
        return 'max:' . $val;
    }

    public static function email(string $validationMethods = 'filter'): string
    {
        return 'email:' . $validationMethods;
    }

    public static function size(int $val): string
    {
        return 'size:' . $val;
    }

    public static function dateFormat(string $format = 'Y-m-d'): string
    {
        return 'date-format:' . $format;
    }

    public static function dateBefore(string $date = self::DATE_TODAY): string
    {
        return 'before:' . $date;
    }
}
