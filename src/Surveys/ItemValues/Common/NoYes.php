<?php

namespace BondarDe\LaravelToolbox\Surveys\ItemValues\Common;

use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;

class NoYes extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'n' => 'Nein',
            'y' => 'Ja',
        ];
    }
}
