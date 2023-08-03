<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

class NoYesUnknown extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'n' => 'Nein',
            'y' => 'Ja',
            'u' => 'Unbekannt',
        ];
    }
}
