<?php

namespace BondarDe\Lox\ModelList;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

abstract class ModelFilters
{
    const ALL = 'all';

    const DEFAULT_FILTER = self::ALL;

    public static function all(): array
    {
        return [
            self::ALL => new ModelFilter(__('all'), fn() => null),
        ];
    }

    public static function makeYearsFilter(string $fieldName, int $firstYear, ?callable $makeModelFilter = null, ?callable $makeFilterKey = null, ?int $lastYear = null): array
    {
        $filters = [];

        $lastYear ??= Carbon::now()->year;
        $makeModelFilter ??= function (int $y) use ($fieldName): ModelFilter {
            return new ModelFilter(
                label: $y,
                query: fn(Builder $q) => $q->whereYear($fieldName, $y),
            );
        };
        $makeFilterKey ??= function (int $y): string {
            return 'year-' . $y;
        };

        for ($y = $firstYear; $y <= $lastYear; $y++) {
            $filters[$makeFilterKey($y)] = $makeModelFilter($y);
        }

        return $filters;
    }

    public static function makeMonthsFilter(string $fieldName, ?callable $makeModelFilter = null, ?callable $makeFilterKey = null): array
    {
        $filters = [];

        $date = Carbon::now()->firstOfMonth();
        $makeModelFilter ??= function (int $m) use ($date, $fieldName): ModelFilter {
            $date->month($m);

            return new ModelFilter(
                label: $date->isoFormat('MMM'),
                query: fn(Builder $q) => $q->whereMonth($fieldName, $m),
            );
        };
        $makeFilterKey ??= function (int $y): string {
            return 'month-' . $y;
        };

        for ($m = 1; $m <= 12; $m++) {
            $filters[$makeFilterKey($m)] = $makeModelFilter($m);
        }

        return $filters;
    }
}
