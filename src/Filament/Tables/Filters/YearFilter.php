<?php

namespace BondarDe\Lox\Filament\Tables\Filters;

use Carbon\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class YearFilter
{
    public static function make(
        string $field,
        ?int $firstYear = null,
        ?int $lastYear = null,
        ?string $filterName = null,
    ): SelectFilter {
        $filterName ??= $field . '.year';
        $filter = SelectFilter::make($filterName);

        return $filter
            ->options(fn () => self::makeOptions($filter, $field, $firstYear, $lastYear))
            ->query(
                fn (Builder $query, array $state) => $state['value'] && $query->whereYear($field, $state['value']),
            );
    }

    private static function makeOptions(
        SelectFilter $filter,
        string $field,
        ?int $firstYear,
        ?int $lastYear,
    ): array {
        $lastYear ??= Carbon::now()->year;
        $firstYear ??= self::toFirstYear($filter, $field)
            ?: $lastYear;

        $options = [];
        for ($y = $lastYear; $y >= $firstYear; $y--) {
            $options[$y] = $y;
        }

        return $options;
    }

    private static function toFirstYear(
        SelectFilter $filter,
        string $field,
    ): ?int {
        $table = $filter->getTable();
        $query = $table->getQuery();
        $minValue = $query->min($field);

        if ($minValue) {
            $minDate = Carbon::parse($minValue);

            return $minDate->year;
        }

        return null;
    }
}
