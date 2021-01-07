<?php

namespace BondarDe\LaravelToolbox\Surveys\ItemValues\Common;

use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;

class Genders extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'f' => 'Weiblich',
            'm' => 'Männlich',
            'd' => 'Divers',
        ];
    }
}
