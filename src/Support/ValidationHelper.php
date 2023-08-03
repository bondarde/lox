<?php

namespace BondarDe\Lox\Support;

use Carbon\Carbon;

class ValidationHelper
{
    public static function toValidSqlDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->format('Y-m-d');
    }
}
