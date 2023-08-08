<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\LiveModelList;
use BondarDe\Lox\ModelList\ModelFilters;
use BondarDe\Lox\Support\ModelList\ModelListUrlQueryUtil;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Filter extends Component
{
    public string $model;

    public bool $showFilters = true;
    public bool $showSorts = true;
    public string $searchQuery;

    private array $activeFilters;
    private array $activeSorts;

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

    public function render(): ?View
    {
        $modelListData = LiveModelList::toModelListData($this->model, request());
        $this->activeFilters = $modelListData->activeFilters;
        $this->activeSorts = $modelListData->activeSorts;

        return view('lox::livewire.model-list.filter', [
            'allFilters' => $modelListData->allFilters,
            'allSorts' => $modelListData->allSorts,
            'routeName' => Route::current()->getName(),
            'routeParams' => Route::current()->parameters(),
            'activeFilters' => $this->activeFilters,
        ]);
    }
}
