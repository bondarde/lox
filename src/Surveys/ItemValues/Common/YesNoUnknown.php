<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

class YesNoUnknown extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'y' => 'Ja',
            'n' => 'Nein',
            'u' => 'Unbekannt',
        ];
    }
}
