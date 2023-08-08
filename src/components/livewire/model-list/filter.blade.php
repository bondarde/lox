<div>
    <pre>{{ json_encode($activeFilters, JSON_PRETTY_PRINT) }}</pre>
    @if($showFilters)
        <div>
            <h4 class="font-semibold">{{ __('Filter') }}</h4>
            @foreach($allFilters as $filters)
                <ul class="flex flex-wrap mb-3 -mx-1 gap-x-4 gap-y-1">
                    @foreach($filters as $key => $filter)
                        @include('lox::_filter-sort-item', [
                            'routeName' => $routeName,
                            'routeParams' => $routeParams,
                            'isActive' => $this->isFilterActive($key),
                            'filter' => $key,
                            'label' => $filter->label,
                            'title' => $filter->title,
                            'filterCount' => $this->toFilterCount($key),
                            'filtersQuery' => $this->toFiltersQueryString($key),
                            'sortsQuery' => $this->toSortsQueryString(),
                            'searchQuery' => $searchQuery,
                            'showDeleteFilterButton' => $key !== \BondarDe\Lox\ModelList\ModelFilters::ALL,
                        ])
                        <li>
                            <livewire:model-list.filter-item-count
                                key="{{ Str::random() }}"
                                :model="$model"
                                :filter-name="$key"
                                lazy
                            />
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    @endif

    @if($showSorts)
        <div>
            <h4 class="font-semibold">{{ __('Sorting') }}</h4>
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
