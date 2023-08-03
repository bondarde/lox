<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

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
