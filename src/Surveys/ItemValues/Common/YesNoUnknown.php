<?php

namespace BondarDe\LaravelToolbox\Surveys\ItemValues\Common;

use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;

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
