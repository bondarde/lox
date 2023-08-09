<?php

namespace BondarDe\Lox\Livewire\ModelList\Support;

use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\ModelList\ModelFilter;
use BondarDe\Lox\ModelList\ModelFilters;
use BondarDe\Lox\ModelList\ModelListFilterable;
use BondarDe\Lox\ModelList\ModelListQueryable;
use BondarDe\Lox\ModelList\ModelListSortable;
use BondarDe\Lox\ModelList\ModelSort;
use BondarDe\Lox\ModelList\ModelSorts;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelListUtil
{
    public static function allFilters(string $model): array
    {
        $filters = self::toModelFilters($model);

        return self::toArrayOfFiltersArray($filters::all());
    }

    public static function allSorts(string $model): array
    {
        $sorts = self::toModelSorts($model);

        return $sorts::all();
    }

    public static function toDefaultSort(string $model): string
    {
        $sorts = self::toModelSorts($model);

        return $sorts::DEFAULT_SORT;
    }

    /**
     * @throws IllegalStateException
     */
    public static function toUnpaginatedQuery(
        string  $model,
        bool    $withTrashed,
        bool    $withArchived,
        array   $activeFilters,
        array   $activeSorts,
        ?string $searchQuery,
    ): Builder
    {
        $query = self::toQueryBuilder($model);

        if ($withTrashed) {
            $query->withTrashed();
        }

        if ($withArchived) {
            $query->withArchived();
        }

        $allFilters = ModelListUtil::allFilters($model);
        $allSorts = ModelListUtil::allSorts($model);

        foreach ($activeFilters as $filterKey) {
            $filter = self::findFilterByKey($allFilters, $filterKey);
            $sql = $filter->query;

            if (!$sql instanceof Closure) {
                throw new IllegalStateException('Closure expected.');
            }

            $sql($query);
        }

        foreach ($activeSorts as $sortKey) {
            $sort = self::findSortByKey($allSorts, $sortKey);
            $query->orderByRaw($sort->sql);
        }

        if ($searchQuery) {
            $values = explode(' ', trim($searchQuery));

            $query->where(function (Builder $q) use ($model, $values) {
                foreach ($values as $value) {
                    foreach ($model::getModelListSearchFields() as $columnOrQueryModifier) {
                        if ($columnOrQueryModifier instanceof Closure) {
                            $columnOrQueryModifier($q, $value);
                        } else if (is_string($columnOrQueryModifier)) {
                            $column = $columnOrQueryModifier;
                            $searchValue = '%' . $value . '%';

                            $q->orWhere($column, 'LIKE', $searchValue);
                        } else {
                            throw new IllegalStateException('Unsupported column config type: "' . gettype($columnOrQueryModifier) . '"');
                        }
                    }
                }
            });
        }

        return $query;
    }


    private static function toModelFilters(string $model): ModelFilters
    {
        if (is_subclass_of($model, ModelListFilterable::class)) {
            $filters = $model::getModelListFilters();

            return new $filters;
        }

        return new class extends ModelFilters {
        };
    }

    private static function toModelSorts(string $model): ModelSorts
    {
        if (is_subclass_of($model, ModelListSortable::class)) {
            $sorts = $model::getModelListSorts();

            return new $sorts;
        }

        return new class extends ModelSorts {
        };
    }


    private static function toArrayOfFiltersArray(array $allFilters): array
    {
        $firstKey = array_key_first($allFilters);
        $firstElement = $allFilters[$firstKey];

        if (!is_array($firstElement)) {
            $allFilters = [$allFilters];
        }

        return $allFilters;
    }


    private static function toQueryBuilder(string $model): Builder
    {
        /** @var Model $model */

        if (is_subclass_of($model, ModelListQueryable::class)) {
            return $model::getModelListQuery();
        }

        return $model::query();
    }

    /**
     * @throws IllegalStateException
     */
    private static function findFilterByKey(array $allFilters, $filterKey): ModelFilter
    {
        foreach ($allFilters as $filters) {
            if (isset($filters[$filterKey])) {
                return $filters[$filterKey];
            }
        }

        throw new IllegalStateException('Unknown filter: ' . $filterKey);
    }

    /**
     * @throws IllegalStateException
     */
    private static function findSortByKey(array $allSorts, $sortKey): ModelSort
    {
        if (!isset($allSorts[$sortKey])) {
            // ignore unknown sort
            throw new IllegalStateException('Unknown sort: ' . $sortKey);
        }

        return $allSorts[$sortKey];
    }
}
