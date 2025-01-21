<?php

namespace BondarDe\Lox\Filament\Tables\Filters;

use Carbon\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class MonthFilter
{
    public static function make(
        string $field,
    ): SelectFilter {
        $options = [];

        $date = Carbon::now()->firstOfMonth();
        for ($m = 1; $m <= 12; $m++) {
            $date->month($m);
            $options[$m] = $date->isoFormat('MMMM');
        }

        return SelectFilter::make($field . '.month')
            ->options($options)
            ->query(
                fn (Builder $query, array $state) => $state['value'] && $query->whereMonth($field, $state['value']),
            );
    }
}
