<?php

namespace BondarDe\LaravelToolbox\Support\ModelList;

use BondarDe\LaravelToolbox\ModelList\ModelFilter;
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
