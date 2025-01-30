<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\ModelList\Support\ModelListUtil;
use BondarDe\Lox\Support\ModelList\ModelListFilterStatsUtil;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class FilterItemCount extends Component
{
    public string $model;
    public string $filterName;
    public array $activeFilters;

    public function placeholder(): string
    {
        return '
        <div'
            . ' class="inline-block cursor-wait bg-current align-middle opacity-25 rounded-sm"'
            . ' style="height: 10px; width: ' . mt_rand(6, 12) . 'px"'
            . '></div>
        ';
    }

    public function render(): View
    {
        $allFilters = ModelListUtil::allFilters($this->model);

        $count = ModelListFilterStatsUtil::toCountWithActiveFilters(
            $this->model,
            $this->filterName,
            $this->activeFilters,
            $allFilters,
        );

        $this->dispatch('filter-count:updated', $this->filterName, $count);

        return view('lox::components.livewire.model-list.filter-item-count', [
            'count' => $count,
        ]);
    }
}
