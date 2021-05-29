<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use BondarDe\LaravelToolbox\ModelList\ModelFilter;
use BondarDe\LaravelToolbox\ModelList\ModelFilters;
use BondarDe\LaravelToolbox\ModelList\ModelSort;
use BondarDe\LaravelToolbox\ModelList\ModelSorts;
use BondarDe\LaravelToolbox\Support\ModelList\ModelListFilterStatsUtil;
use BondarDe\LaravelToolbox\Support\ModelList\ModelListUrlQueryUtil;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ModelList extends Component
{
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
        string $filters = null,
        string $sorts = null,
        bool $withTrashed = false
    )
    {
        self::assertIsSubclassOf($model, Model::class);
        if ($filters) {
            self::assertIsSubclassOf($filters, ModelFilters::class);
        } else {
            $filters = new class extends ModelFilters {
            };
        }
        if ($sorts) {
            self::assertIsSubclassOf($sorts, ModelSorts::class);
        } else {
            $sorts = new class extends ModelSorts {
            };
        }


        $this->allFilters = self::toArrayOfFiltersArray($filters::all());
        $this->allSorts = $sorts::all();

        $this->activeFilters = explode(',', $request->get('filters') ?? $filters::DEFAULT_FILTER);
        $this->activeSorts = explode(',', $request->get('sort') ?? $sorts::DEFAULT_SORT);
        $activePage = $request->get('page') ?? 1;

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
            'filters' => ModelListUrlQueryUtil::toQueryString($this->activeFilters),
            'sort' => ModelListUrlQueryUtil::toQueryString($this->activeFilters),
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
        /** @var Model $model */
        $query = $model::query();
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
