<?php

namespace BondarDe\LaravelToolbox\Surveys\ItemValues\Common;

use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;

class StatesDACH extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'Deutschland' => StatesDE::all(),
            'Österreich' => StatesAT::all(),
            'Schweiz' => StatesCH::all(),
        ];
    }
}
