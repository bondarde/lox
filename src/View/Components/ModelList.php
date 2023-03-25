<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use BondarDe\LaravelToolbox\ModelList\ModelFilter;
use BondarDe\LaravelToolbox\ModelList\ModelFilters;
use BondarDe\LaravelToolbox\ModelList\ModelListFilterable;
use BondarDe\LaravelToolbox\ModelList\ModelListQueryable;
use BondarDe\LaravelToolbox\ModelList\ModelListSearchable;
use BondarDe\LaravelToolbox\ModelList\ModelListSortable;
use BondarDe\LaravelToolbox\ModelList\ModelSort;
use BondarDe\LaravelToolbox\ModelList\ModelSorts;
use BondarDe\LaravelToolbox\ModelListData;
use BondarDe\LaravelToolbox\Support\ModelList\ModelListFilterStatsUtil;
use BondarDe\LaravelToolbox\Support\ModelList\ModelListUrlQueryUtil;
use BondarDe\LaravelToolbox\Support\NumbersFormatter;
use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ModelList extends Component
{
    public const URL_PARAM_FILTERS = 'filters';
    public const URL_PARAM_SORTS = 'sort';
    public const URL_PARAM_SEARCH_QUERY = 'q';
    public const URL_PARAM_PAGE = 'page';
    public const URL_PARAM_SEPARATOR = ',';

    public LengthAwarePaginator $items;
    public string $pageTitle;
    public Htmlable $links;

    public array $allFilters;
    public array $allSorts;

    public bool $showFilters;
    public bool $showSorts;
    public bool $showSearchQuery;

    private array $activeFilters;
    private array $activeSorts;
    private array $filterStats;
    public ?string $searchQuery;

    /**
     * @throws IllegalStateException
     */
    public function __construct(
        Request $request,
        string  $model,
        bool    $withTrashed = false,
        bool    $withArchived = false,
        int     $hideCountsOver = 1_000_000,
        string  $pageTitle = '{0} No entries|{1} One entry|[2,*] :count entries',
    )
    {
        self::assertIsSubclassOf($model, Model::class);

        $modelListData = self::toModelListData($model, $request);

        $this->allFilters = $modelListData->allFilters;
        $this->allSorts = $modelListData->allSorts;
        $this->activeFilters = $modelListData->activeFilters;
        $this->activeSorts = $modelListData->activeSorts;
        $this->searchQuery = $modelListData->searchQuery;

        $query = self::toUnpaginatedQuery($modelListData, $withTrashed, $withArchived);
        $this->items = self::toItems($model, $query, $modelListData->activePage);
        $this->filterStats = ModelListFilterStatsUtil::toFilterStats(
            $model,
            $this->allFilters,
            $this->activeFilters,
            $hideCountsOver,
        );

        $this->links = $this->items->appends([
            self::URL_PARAM_FILTERS => ModelListUrlQueryUtil::toQueryString($this->activeFilters),
            self::URL_PARAM_SORTS => ModelListUrlQueryUtil::toQueryString($this->activeSorts),
            self::URL_PARAM_SEARCH_QUERY => $this->searchQuery,
        ])->links();
        $this->pageTitle = self::toPageTitle($pageTitle, $this->items->total());

        $this->showFilters = is_subclass_of($model, ModelListFilterable::class);
        $this->showSorts = is_subclass_of($model, ModelListSortable::class);
        $this->showSearchQuery = is_subclass_of($model, ModelListSearchable::class);
    }

    public static function toModelListData(
        string  $model,
        Request $request,
    ): ModelListData
    {
        $filters = self::toModelFilters($model);
        $sorts = self::toModelSorts($model);

        $activePage = $request->get(self::URL_PARAM_PAGE, 1);
        $allFilters = self::toArrayOfFiltersArray($filters::all());
        $allSorts = $sorts::all();
        $activeFilters = explode(self::URL_PARAM_SEPARATOR, $request->get(self::URL_PARAM_FILTERS) ?? $filters::DEFAULT_FILTER);
        $activeSorts = explode(self::URL_PARAM_SEPARATOR, $request->get(self::URL_PARAM_SORTS) ?? $sorts::DEFAULT_SORT);
        $searchQuery = $request->get(self::URL_PARAM_SEARCH_QUERY);

        return new ModelListData(
            $model,
            $activePage,
            $allFilters,
            $activeFilters,
            $allSorts,
            $activeSorts,
            $searchQuery,
        );
    }

    /**
     * @throws IllegalStateException
     */
    public static function toUnpaginatedQuery(
        ModelListData $modelListData,
        bool          $withTrashed = false,
        bool          $withArchived = false,
    ): Builder
    {
        $query = self::toQueryBuilder($modelListData->model);

        if ($withTrashed) {
            $query->withTrashed();
        }

        if ($withArchived) {
            $query->withArchived();
        }

        $activeFilters = $modelListData->activeFilters;
        $allFilters = $modelListData->allFilters;
        $activeSorts = $modelListData->activeSorts;
        $allSorts = $modelListData->allSorts;

        foreach ($activeFilters as $filterKey) {
            $filter = self::findFilterByKey($allFilters, $filterKey);
            $sql = $filter->sql;

            if ($sql === 'TRUE') {
                continue;
            }

            $sql = '(' . $sql . ')';
            $query->whereRaw($sql);
        }
        foreach ($activeSorts as $sortKey) {
            $sort = self::findSortByKey($allSorts, $sortKey);
            $query->orderByRaw($sort->sql);
        }
        if ($modelListData->searchQuery && is_subclass_of($modelListData->model, ModelListSearchable::class)) {
            $modelInstance = new $modelListData->model;

            $values = explode(' ', trim($modelListData->searchQuery));

            $query->where(function (Builder $q) use ($modelInstance, $modelListData, $values) {
                foreach ($values as $value) {
                    foreach ($modelInstance::getModelListSearchFields() as $columnOrQueryModifier) {
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

    private static function toItems(
        string  $model,
        Builder $query,
        int     $page
    ): LengthAwarePaginator
    {
        return $query
            ->paginate(
                (new $model)->getPerPage(),
                ['*'],
                'page',
                $page
            );
    }

    private static function toPageTitle(
        string $pageTitle,
        int    $totalCount,
    ): string
    {
        return trans_choice($pageTitle, $totalCount, [
            'count' => NumbersFormatter::format($totalCount),
        ]);
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

    private static function toQueryBuilder(string $model): Builder
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

    public function toFilterCount(string $filter): ?int
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

        return $this->filterStats[$key]['count'] ?? null;
    }

    public function toFiltersQueryString(?string $filter = null): string
    {
        if (!$filter) {
            $filters = $this->activeFilters;
        } else if ($filter === ModelFilters::ALL) {
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

    public function render(): View
    {
        return view('laravel-toolbox::model-list');
    }
}
