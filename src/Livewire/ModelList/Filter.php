<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\ModelList\Support\ModelListUtil;
use BondarDe\Lox\ModelList\ModelFilters;
use BondarDe\Lox\Support\ModelList\ModelListUrlQueryUtil;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public string $model;

    public bool $supportsFilters;
    public bool $supportsSorts;

    public array $activeFilters;
    public array $activeSorts;

    public function isFilterActive(string $filter): bool
    {
        $idx = ModelListUrlQueryUtil::toFilterIndex($this->activeFilters, $filter);

        return $idx >= 0;
    }

    public function isSortActive(string $sortName): bool
    {
        $idx = ModelListUrlQueryUtil::toSortIndex($this->activeSorts, $sortName);

        return $idx >= 0;
    }

    public function renderSortDirection(string $key): ?string
    {
        if (!$this->isSortActive($key)) {
            return null;
        }

        $idx = ModelListUrlQueryUtil::toSortIndex($this->activeSorts, $key);
        $sortName = $this->activeSorts[$idx];

        if (str_ends_with($sortName, '-')) {
            return '▼';
        }

        return '▲';
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
        $allFilters = ModelListUtil::allFilters($this->model);
        $allSorts = ModelListUtil::allSorts($this->model);

        return view('lox::livewire.model-list.filter', [
            'allFilters' => $allFilters,
            'allSorts' => $allSorts,
        ]);
    }
}
