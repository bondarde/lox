<?php

namespace BondarDe\LaravelToolbox\Surveys\ItemValues\Common;

use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;

class StatesAT extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'at-1' => 'Burgenland',
            'at-2' => 'Kärnten',
            'at-3' => 'Niederösterreich',
            'at-4' => 'Oberösterreich',
            'at-5' => 'Salzburg',
            'at-6' => 'Steiermark',
            'at-7' => 'Tirol',
            'at-8' => 'Vorarlberg',
            'at-9' => 'Wien',
        ];
    }
}
