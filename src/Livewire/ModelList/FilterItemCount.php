<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\LiveModelList;
use BondarDe\Lox\Support\ModelList\ModelListFilterStatsUtil;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class FilterItemCount extends Component
{
    public string $model;
    public string $filterName;

    public function placeholder(): string
    {
        return '
        <div class="inline-block h-[10px] w-[20px] flex-auto cursor-wait bg-current align-middle opacity-50 rounded-sm"></div>
        ';
    }

    public function render(): View
    {
        $modelListData = LiveModelList::toModelListData($this->model, request());
        $activeFilters = $modelListData->activeFilters;
        $allFilters = $modelListData->allFilters;

        $count = ModelListFilterStatsUtil::toCountWithActiveFilters(
            $this->model,
            $this->filterName,
            $activeFilters,
            $allFilters,
        );

        return view('lox::livewire.model-list.filter-item-count', [
            'count' => $count,
        ]);
    }
}
