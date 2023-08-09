<div>
    @if($supportsFilters)
        <div class="flex flex-col gap-3">
            @foreach($allFilters as $filters)
                <div class="flex flex-wrap gap-x-4 gap-y-1">
                    @foreach($filters as $key => $filter)
                        <button
                            @class([
                                'cursor-pointer px-2 py-1 gap-1',
                                'rounded-md transition-colors duration-200 hover:bg-indigo-600 hover:text-white hover:shadow dark:hover:bg-indigo-500 dark:hover:text-gray-200 shadow bg-indigo-600 text-white dark:bg-indigo-500 dark:text-gray-200' => $this->isFilterActive($key),
                            ])
                            wire:click="$parent.toggleFilter('{{ $key }}')"
                        >
                            {{ $filter->label }}
                            <livewire:model-list.filter-item-count
                                key="{{ Str::random() }}"
                                :$model
                                :$activeFilters
                                :filter-name="$key"
                                lazy
                            />
                        </button>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

    @if($supportsFilters && $supportsSorts)
        <hr class="my-2">
    @endif

    @if($supportsSorts)
        <div class="flex flex-wrap gap-x-4 gap-y-1">
            @foreach($allSorts as $key => $sort)
                <button
                    @class([
                        'cursor-pointer px-2 py-1 gap-1',
                        'rounded-md transition-colors duration-200 hover:bg-indigo-600 hover:text-white hover:shadow dark:hover:bg-indigo-500 dark:hover:text-gray-200 shadow bg-indigo-600 text-white dark:bg-indigo-500 dark:text-gray-200' => $this->isSortActive($key),
                    ])
                    wire:click="$parent.toggleSort('{{ $key }}')"
                >
                    {{ $sort->label }}
                    <span
                        class="opacity-75 text-sm"
                    >{{ $this->renderSortDirection($key) }}</span>
                </button>
            @endforeach
        </div>
    @endif
</div>
