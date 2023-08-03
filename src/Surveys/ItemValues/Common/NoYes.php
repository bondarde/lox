<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

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
