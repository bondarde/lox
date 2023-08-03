<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

class YesNo extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'y' => 'Ja',
            'n' => 'Nein',
        ];
    }
}
