<div>
    @if($supportsFilters)
        <div>
            <div class="font-semibold">{{ __('Filter') }}</div>
            @foreach($allFilters as $filters)
                <div class="flex flex-wrap mb-3 -mx-1 gap-x-4 gap-y-1">
                    @foreach($filters as $key => $filter)
                        <button
                            @class([
                                'cursor-pointer px-2 py-1',
                                'px-4_py-2 rounded-md transition-colors duration-200 hover:bg-indigo-600 hover:text-white hover:shadow dark:hover:bg-indigo-500 dark:hover:text-gray-200 font-semibold shadow bg-indigo-600 text-white dark:bg-indigo-500 dark:text-gray-200' => $this->isFilterActive($key),
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

    @if($supportsSorts)
        <div>
            <div class="font-semibold">{{ __('Sorting') }}</div>
            <ul class="flex flex-wrap mb-2 gap-x-4 gap-y-1">
                @foreach($allSorts as $key => $sort)
                    @include('lox::_filter-sort-item', [
                        'routeName' => $routeName,
                        'routeParams' => $routeParams,
                        'isActive' => $this->isSortActive($key),
                        'label' => $sort->label,
                        'title' => $sort->title,
                        'filtersQuery' => $this->toFiltersQueryString(),
                        'sortsQuery' => $this->toSortsQueryString($key),
                        'searchQuery' => $searchQuery,
                    ])
                @endforeach
            </ul>
        </div>
    @endif
</div>
