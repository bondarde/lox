<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use BondarDe\LaravelToolbox\ModelList\ModelFilter;
use BondarDe\LaravelToolbox\ModelList\ModelFilters;
use BondarDe\LaravelToolbox\ModelList\ModelListFilterable;
use BondarDe\LaravelToolbox\ModelList\ModelListQueryable;
use BondarDe\LaravelToolbox\ModelList\ModelListSortable;
use BondarDe\LaravelToolbox\ModelList\ModelSort;
use BondarDe\LaravelToolbox\ModelList\ModelSorts;
use BondarDe\LaravelToolbox\Support\ModelList\ModelListFilterStatsUtil;
use BondarDe\LaravelToolbox\Support\ModelList\ModelListUrlQueryUtil;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ModelList extends Component
{
    public const URL_PARAM_FILTERS = 'filters';
    public const URL_PARAM_SORTS = 'sort';

    public LengthAwarePaginator $items;
    public string $pageTitle;
    public Htmlable $links;

    public array $allFilters;
    public array $allSorts;

    private array $activeFilters;
    private array $activeSorts;
    private array $filterStats;

    /**
     * @throws IllegalStateException
     */
    public function __construct(
        Request $request,
        string $model,
        bool $withTrashed = false
    )
    {
        self::assertIsSubclassOf($model, Model::class);

        $filters = self::toModelFilters($model);
        $sorts = self::toModelSorts($model);

        $this->allFilters = self::toArrayOfFiltersArray($filters::all());
        $this->allSorts = $sorts::all();

        $this->activeFilters = explode(',', $request->get(self::URL_PARAM_FILTERS) ?? $filters::DEFAULT_FILTER);
        $this->activeSorts = explode(',', $request->get(self::URL_PARAM_SORTS) ?? $sorts::DEFAULT_SORT);
        $activePage = $request->get('page', 1);

        $this->filterStats = ModelListFilterStatsUtil::toFilterStats($model, $this->allFilters, $this->activeFilters);

        $this->items = self::toItems(
            $model,
            $activePage,
            $this->allFilters,
            $this->activeFilters,
            $this->allSorts,
            $this->activeSorts,
            $withTrashed
        );

        $this->links = $this->items->appends([
            self::URL_PARAM_FILTERS => ModelListUrlQueryUtil::toQueryString($this->activeFilters),
            self::URL_PARAM_SORTS => ModelListUrlQueryUtil::toQueryString($this->activeSorts),
        ])->links();
        $this->pageTitle = self::toPageTitle($this->items->total());
    }

    /**
     * @throws IllegalStateException
     */
    private static function toItems(
        string $model,
        int $page,
        array $allFilters,
        array $activeFilters,
        array $allSorts,
        array $activeSorts,
        bool $withTrashed
    ): LengthAwarePaginator
    {
        $query = self::toQueryBuilder($model);

        if ($withTrashed) {
            $query->withTrashed();
        }

        foreach ($activeFilters as $filterKey) {
            $filter = self::findFilterByKey($allFilters, $filterKey);
            $query->whereRaw($filter->sql);
        }
        foreach ($activeSorts as $sortKey) {
            $sort = self::findSortByKey($allSorts, $sortKey);
            $query->orderByRaw($sort->sql);
        }

        return $query
            ->paginate(
                (new $model)->getPerPage(),
                ['*'],
                'page',
                $page
            );
    }

    private static function toPageTitle(int $totalCount): string
    {
        $singularPlural = ['Eintrag', 'Einträge'];
        $singular = $singularPlural[0];
        $plural = $singularPlural[1] ?? $singular;

        return self::format($totalCount, 0, '', 'Keine') . ' '
            . ($totalCount === 1 ? $singular : $plural);
    }

    private static function format($num, $decimals = 0, $suffix = '', $zero = '<span class="text-muted">—</span>')
    {
        if ($num == 0) {
            return $zero;
        }

        $prefix = $num < 0 ? '–' : '';

        if ($suffix) {
            $suffix = '<small class="text-muted">&thinsp;' . $suffix . '</small>';
        }

        return $prefix . number_format(abs($num), $decimals, ',', '.') . $suffix;
    }

    /**
     * @throws IllegalStateException
     */
    private static function assertIsSubclassOf(string $className, string $parentClassName): void
    {
        if (!is_subclass_of($className, $parentClassName)) {
            throw new IllegalStateException($className . ' must be a subclass of ' . $parentClassName);
        }
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

    private static function toArrayOfFiltersArray(array $allFilters): array
    {
        $firstKey = array_key_first($allFilters);
        $firstElement = $allFilters[$firstKey];

        if (!is_array($firstElement)) {
            $allFilters = [$allFilters];
        }

        return $allFilters;
    }

    private static function toQueryBuilder(string $model): EloquentBuilder
    {
        /** @var Model $model */

        if (is_subclass_of($model, ModelListQueryable::class)) {
            return $model::getModelListQuery();
        }

        return $model::query();
    }

    private static function toModelFilters(string $model): ModelFilters
    {
        if (is_subclass_of($model, ModelListFilterable::class)) {
            $filters = (new $model)::getModelListFilters();
            return new $filters;
        }

        return new class extends ModelFilters {
        };
    }

    private static function toModelSorts(string $model): ModelSorts
    {
        if (is_subclass_of($model, ModelListSortable::class)) {
            $sorts = (new $model)::getModelListSorts();
            return new $sorts;
        }

        return new class extends ModelSorts {
        };
    }

    public function isFilterActive(string $filter): bool
    {
        $idx = ModelListUrlQueryUtil::toFilterIndex($this->activeFilters, $filter);

        return $idx >= 0;
    }

    public function isSortActive(string $sort): bool
    {
        $idx = ModelListUrlQueryUtil::toFilterIndex($this->activeSorts, $sort);

        return $idx >= 0;
    }

    public function toFilterCount(string $filter): int
    {
        if ($filter === ModelFilters::ALL) {
            $key = ModelFilters::ALL;
        } else {
            $filters = $this->activeFilters;
            $filters[] = $filter;
            $filters = array_unique($filters);
            sort($filters);

            $key = ModelListUrlQueryUtil::toQueryString($filters);
        }

        return $this->filterStats[$key]['count'];
    }

    public function toFiltersQueryString(?string $filter = null): string
    {
        if (!$filter) {
            $filters = $this->activeFilters;
        } elseif ($filter === ModelFilters::ALL) {
            return ModelFilters::ALL;
        } else {
            $idx = ModelListUrlQueryUtil::toFilterIndex($this->activeFilters, $filter);

            $filters = $idx === -1
                ? ModelListUrlQueryUtil::merge($this->activeFilters, [$filter])
                : ModelListUrlQueryUtil::removeByIdx($this->activeFilters, $idx);
        }

        return ModelListUrlQueryUtil::toQueryString($filters);
    }

    public function toSortsQueryString(?string $sort = null): string
    {
        return $sort ?: '';
    }

    public function render()
    {
        return view('laravel-toolbox::model-list');
    }
}
