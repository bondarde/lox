<?php

namespace BondarDe\LaravelToolbox\Support;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

class NumbersFormatter
{
    public static function format(
        float|int $number,
        int       $decimals = 0,
        ?string   $suffix = null,
        string    $zero = '<span class="opacity-50">—</span>',
    ): string
    {
        if ($number == 0) {
            return $zero;
        }

        $prefix = $number < 0 ? '–' : '';

        if ($suffix) {
            $suffix = '<small class="opacity-50">&thinsp;' . $suffix . '</small>';
        }

        $thousands_separator = __(LaravelToolboxServiceProvider::NAMESPACE . '::numbers.thousands_separator');
        $decimal_separator = __(LaravelToolboxServiceProvider::NAMESPACE . '::numbers.decimal_separator');

        $formatted = number_format(abs($number), $decimals, $decimal_separator, $thousands_separator);

        return $prefix . $formatted . $suffix;
    }
}
