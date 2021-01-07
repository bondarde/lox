<?php

namespace BondarDe\LaravelToolbox\Surveys\ItemValues\Common;

use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;

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
