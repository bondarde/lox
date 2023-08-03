<?php

namespace BondarDe\Lox\Surveys\ItemValues\Common;

use BondarDe\Lox\Surveys\SurveyItemValues;

class StatesDE extends SurveyItemValues
{
    public static function all(): array
    {
        return [
            'de-bw' => 'Baden-Württemberg',
            'de-by' => 'Bayern',
            'de-be' => 'Berlin',
            'de-bb' => 'Brandenburg',
            'de-hb' => 'Bremen',
            'de-hh' => 'Hamburg',
            'de-he' => 'Hessen',
            'de-mv' => 'Mecklenburg-Vorpommern',
            'de-ni' => 'Niedersachsen',
            'de-nw' => 'Nordrhein-Westfalen',
            'de-rp' => 'Rheinland-Pfalz',
            'de-sl' => 'Saarland',
            'de-sn' => 'Sachsen',
            'de-st' => 'Sachsen-Anhalt',
            'de-sh' => 'Schleswig-Holstein',
            'de-th' => 'Thüringen',
        ];
    }
}
