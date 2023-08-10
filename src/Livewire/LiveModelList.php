<?php

namespace BondarDe\Lox\Livewire;

use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\Livewire\ModelList\Support\ModelListUtil;
use BondarDe\Lox\ModelList\ModelFilters;
use BondarDe\Lox\ModelList\ModelListFilterable;
use BondarDe\Lox\ModelList\ModelListSearchable;
use BondarDe\Lox\ModelList\ModelListSortable;
use BondarDe\Lox\Support\ModelList\ModelListUrlQueryUtil;
use BondarDe\Lox\Support\NumbersFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LiveModelList extends Component
{
    use WithPagination;

    public const URL_PARAM_FILTERS = 'filters';
    public const URL_PARAM_SORTS = 'sort';
    public const URL_PARAM_SEARCH_QUERY = 'q';
    public const URL_PARAM_PAGE = 'page';
    public const URL_PARAM_SEPARATOR = ',';

    public string $model;

    #[Url(as: self::URL_PARAM_PAGE)]
    public ?string $currentPage = null;

    #[Url(as: self::URL_PARAM_SEARCH_QUERY)]
    public string $searchQuery = '';

    #[Url(as: self::URL_PARAM_FILTERS)]
    public ?string $filters = null;

    #[Url(as: self::URL_PARAM_SORTS)]
    public ?string $sorts = null;

    public bool $supportsFilters;
    public bool $supportsSorts;
    public bool $supportsTextSearch;

    public bool $isFilterPanelVisible = false;
    public int $filterBadgeCount = 0;

    public array $activeFilters;
    public array $activeSorts;

    public string $currentPath;
    public string $routeName;
    public array $routeParams;

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
        $this->currentPath = '/' . request()->path();

        $this->supportsFilters = is_subclass_of($this->model, ModelListFilterable::class) && $this->model::getModelListFilters() !== null;
        $this->supportsSorts = is_subclass_of($this->model, ModelListSortable::class) && $this->model::getModelListSorts() !== null;
        $this->supportsTextSearch = is_subclass_of($this->model, ModelListSearchable::class) && $this->model::getModelListSearchFields() !== null;

        $this->activeFilters = explode(',', $this->filters ?? ModelFilters::ALL);
        $this->activeSorts = $this->sorts
            ? explode(',', $this->sorts)
            : ModelListUtil::toDefaultSort($this->model);

        $this->updateFilterBadgeCount();
    }

    private function updateFilterBadgeCount(): void
    {
        $this->filterBadgeCount = collect($this->activeFilters)
            ->filter(fn(string $s) => $s !== ModelFilters::ALL)
            ->count();
    }

    #[On('live-model-list:search-query-changed')]
    public function onSearchValueChange(string $newValue): void
    {
        $this->searchQuery = $newValue;
        $this->currentPage = null;
    }

    public function toggleFilter(string $filterName): void
    {
        $this->currentPage = null;

        if ($filterName === ModelFilters::ALL) {
            if (!in_array(ModelFilters::ALL, $this->activeFilters)) {
                // remove all other filters, set active to "all"
                $this->activeFilters = [ModelFilters::ALL];
                $this->filters = '';
            }

            $this->updateFilterBadgeCount();

            return;
        }

        // always remove "all"
        $this->removeActiveFilter(ModelFilters::ALL);

        $providedFilterRemoved = $this->removeActiveFilter($filterName);
        if (!$providedFilterRemoved) {
            // add filter
            $this->activeFilters[] = $filterName;
        }

        $this->filters = implode(',', $this->activeFilters);

        if (!count($this->activeFilters)) {
            $this->activeFilters[] = ModelFilters::ALL;
        }

        $this->updateFilterBadgeCount();
    }

    private function removeActiveFilter(string $filterName): bool
    {
        $idx = array_search($filterName, $this->activeFilters);
        if ($idx !== false) {
            array_splice($this->activeFilters, $idx, 1);

            return true;
        }

        return false;
    }

    public function toggleSort(string $sortName): void
    {
        $idx = ModelListUrlQueryUtil::toSortIndex($this->activeSorts, $sortName);

        if ($idx > -1) {
            $foundSortName = $this->activeSorts[$idx];
            if (str_ends_with($foundSortName, '-')) {
                // DESC sort => remove sort
                array_splice($this->activeSorts, $idx, 1);
            } else {
                // replace ASC sort by DESC
                $descSortName = $sortName . '-';
                array_splice($this->activeSorts, $idx, 1, $descSortName);
            }
        } else {
            // add ASC sort
            $this->activeSorts[] = $sortName;
        }

        $this->sorts = implode(',', $this->activeSorts);
    }

    /**
     * @throws IllegalStateException
     */
    private function toUnpaginatedQuery(): Builder
    {
        return ModelListUtil::toUnpaginatedQuery(
            $this->model,
            $this->withTrashed,
            $this->withArchived,
            $this->activeFilters,
            $this->activeSorts,
            $this->supportsTextSearch ? $this->searchQuery : null,
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

    /**
     * @throws IllegalStateException
     */
    private static function assertIsSubclassOf(string $className, string $parentClassName): void
    {
        if (!is_subclass_of($className, $parentClassName)) {
            throw new IllegalStateException($className . ' must be a subclass of ' . $parentClassName);
        }
    }

    private function getItemsPaginator(): LengthAwarePaginator
    {
        $query = $this->toUnpaginatedQuery();

        $paginator = $query
            ->paginate(
                (new $this->model)->getPerPage(),
                ['*'],
                'page',
                $this->currentPage ?: '',
            );
        $paginator
            ->setPath($this->currentPath)
            ->appends([
                self::URL_PARAM_FILTERS => ModelListUrlQueryUtil::toQueryString($this->activeFilters),
                self::URL_PARAM_SORTS => ModelListUrlQueryUtil::toQueryString($this->activeSorts),
                self::URL_PARAM_SEARCH_QUERY => $this->searchQuery,
            ]);

        return $paginator;
    }

    public function render(): ?View
    {
        $itemsPaginator = $this->getItemsPaginator();

        $items = collect($itemsPaginator->items());
        $links = $itemsPaginator->hasPages()
            ? $itemsPaginator->links('lox::pagination')
            : null;
        $pageTitle = self::toPageTitle($this->pageTitle, $itemsPaginator->total());

        return view('lox::livewire.model-list.index', compact(
            'items',
            'links',
            'pageTitle'
        ));
    }
}
