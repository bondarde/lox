<?php

namespace BondarDe\Lox\Livewire;

use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\LoxServiceProvider;
use BondarDe\Lox\ModelList\ModelFilter;
use BondarDe\Lox\ModelList\ModelFilters;
use BondarDe\Lox\ModelList\ModelListFilterable;
use BondarDe\Lox\ModelList\ModelListQueryable;
use BondarDe\Lox\ModelList\ModelListSearchable;
use BondarDe\Lox\ModelList\ModelListSortable;
use BondarDe\Lox\ModelList\ModelSort;
use BondarDe\Lox\ModelList\ModelSorts;
use BondarDe\Lox\ModelListData;
use BondarDe\Lox\Support\ModelList\ModelListUrlQueryUtil;
use BondarDe\Lox\Support\NumbersFormatter;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class LiveModelList extends Component
{
    public const URL_PARAM_FILTERS = 'filters';
    public const URL_PARAM_SORTS = 'sort';
    public const URL_PARAM_SEARCH_QUERY = 'q';
    public const URL_PARAM_PAGE = 'page';
    public const URL_PARAM_SEPARATOR = ',';

    public string $model;

    #[Url(as: self::URL_PARAM_SEARCH_QUERY)]
    public string $searchQuery = '';

    private array $allFilters;
    private array $allSorts;

    public bool $showFilters;
    public bool $showSorts;
    public bool $showSearchQuery;

    public bool $isFilterPanelVisible = false;

    private array $activeFilters;
    private array $activeSorts;
    private array $filterStats;


    private readonly string $routeName;
    private readonly array $routeParams;

    private bool $withTrashed = false;
    private bool $withArchived = false;
    private int $hideCountsOver = 1_000_000;
    private string $pageTitle = '{0} No entries|{1} One entry|[2,*] :count entries';

    /**
     * @throws IllegalStateException
     */
    public function mount(): void
    {
        self::assertIsSubclassOf($this->model, Model::class);

        $this->routeName = Route::current()->getName();
        $this->routeParams = Route::current()->parameters();

        $this->showFilters = is_subclass_of($this->model, ModelListFilterable::class);
        $this->showSorts = is_subclass_of($this->model, ModelListSortable::class);
        $this->showSearchQuery = is_subclass_of($this->model, ModelListSearchable::class);
    }

    #[On('live-model-list:search-query-changed')]
    public function onSearchValueChange(string $newValue): void
    {
        $this->searchQuery = $newValue;
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

        return new ModelListData(
            $model,
            $activePage,
            $allFilters,
            $activeFilters,
            $allSorts,
            $activeSorts,
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
            $sql = $filter->query;

            if ($sql instanceof Closure) {
                $sql($query);
                continue;
            }

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

    public function render(): ?View
    {
        $request = request();

        $modelListData = self::toModelListData(
            $this->model,
            $request,
        );
        // TODO: improve:
        $modelListData->searchQuery = $this->searchQuery;

        $this->allFilters = $modelListData->allFilters;
        $this->allSorts = $modelListData->allSorts;
        $this->activeFilters = $modelListData->activeFilters;
        $this->activeSorts = $modelListData->activeSorts;

        $query = self::toUnpaginatedQuery($modelListData, $this->withTrashed, $this->withArchived);
        $itemsPaginator = self::toItems($this->model, $query, $modelListData->activePage);

        $links = $itemsPaginator->appends([
            self::URL_PARAM_FILTERS => ModelListUrlQueryUtil::toQueryString($this->activeFilters),
            self::URL_PARAM_SORTS => ModelListUrlQueryUtil::toQueryString($this->activeSorts),
            self::URL_PARAM_SEARCH_QUERY => $this->searchQuery,
        ])->links(LoxServiceProvider::NAMESPACE . '::pagination');
        $pageTitle = self::toPageTitle($this->pageTitle, $itemsPaginator->total());

        $items = collect($itemsPaginator->items());

        return view('lox::livewire.model-list.index')->with(compact(
            'items',
            'links',
            'pageTitle'
        ));
    }
}
