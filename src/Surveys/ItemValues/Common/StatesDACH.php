<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

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
