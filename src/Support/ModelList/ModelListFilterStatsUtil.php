<?php

namespace BondarDe\Lox\Support\ModelList;

use BondarDe\Lox\ModelList\ModelFilter;
use BondarDe\Lox\ModelList\ModelFilters;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelListFilterStatsUtil
{
    public static function toFilterStats(
        string $model,
        array  $allFilters,
        array  $activeFilters,
        int    $hideCountsOver,
    ): array
    {
        $calculateCounts = true;
        $res = [];

        $flattenedFilters = array_merge([], ...$allFilters);

        foreach ($flattenedFilters as $filter => $dbFilter) {
            if (!$calculateCounts) {
                continue;
            }
            /** @var ModelFilter $dbFilter */
            /** @var Model $model */

            $query = $model::query();
            if ($filter === 'deleted') {
                $query = $model::query()->withTrashed();
            }

            $sql = $dbFilter->query;
            if ($sql instanceof Closure) {
                $sql($query);
            } else {
                $query->whereRaw($sql);
            }

            $count = $query->count();
            $res[$filter] = [
                'count' => $count,
            ];

            if ($count >= $hideCountsOver) {
                $calculateCounts = false;
                continue;
            }

            self::addActiveFilters($res, $query, $filter, $activeFilters, $flattenedFilters);
        }

        return $res;
    }

    public static function toCountWithActiveFilters(
        $model,
        string $filterName,
        array $activeFilters,
        array $allFilters,
    ): int
    {
        $query = $model::query();
        $flattenedFilters = array_merge([], ...$allFilters);
        $tmp = [];

        if ($filterName === ModelFilters::ALL) {
            $activeFilters = [ModelFilters::ALL];
        }

        self::addActiveFilters(
            $tmp,
            $query,
            $filterName,
            $activeFilters,
            $flattenedFilters,
        );
        $key = array_key_first($tmp);

        return $tmp[$key]['count'];
    }

    private static function addActiveFilters(
        array   &$res,
        Builder $query,
        string  $filter,
        array   $activeFilters,
        array   $allFilters,
    ): void
    {
        if (!in_array($filter, $activeFilters)) {
            $activeFilters[] = $filter;
        }

        sort($activeFilters);
        $key = ModelListUrlQueryUtil::toQueryString($activeFilters);

        if (isset($res[$key])) {
            return;
        }

        foreach ($activeFilters as $activeFilter) {
            $sql = $allFilters[$activeFilter]->query;

            if ($sql instanceof Closure) {
                $sql($query);
            } else {
                $query->whereRaw($sql);
            }
        }

        $count = $query->count();
        $res[$key] = [
            'count' => $count,
        ];
    }
}
