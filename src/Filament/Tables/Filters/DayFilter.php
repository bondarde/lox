<?php

namespace BondarDe\Lox\Filament\Tables\Filters;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class DayFilter
{
    public static function make(
        string $field,
        ?string $filterName = null,
    ): SelectFilter {
        $options = collect(range(1, 31))
            ->mapWithKeys(fn (int $day) => [$day => $day]);

        $filterName ??= $field . '.day';

        return SelectFilter::make($filterName)
            ->options($options)
            ->query(
                fn (Builder $query, array $state) => $state['value'] && $query->whereDay($field, $state['value']),
            );
    }
}
