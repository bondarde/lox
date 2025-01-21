<?php

namespace BondarDe\Lox\Filament\Tables\Filters;

use Carbon\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class YearFilter
{
    public static function make(
        string $field,
        int $firstYear,
        ?int $lastYear = null,
    ): SelectFilter {
        $options = [];
        $lastYear ??= Carbon::now()->year;

        for ($y = $lastYear; $y >= $firstYear; $y--) {
            $options[$y] = $y;
        }

        return SelectFilter::make($field . '.year')
            ->options($options)
            ->query(
                fn (Builder $query, array $state) => $state['value'] && $query->whereYear($field, $state['value']),
            );
    }
}
