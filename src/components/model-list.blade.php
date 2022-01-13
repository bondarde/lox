<div @if($showFilters || $showSorts || $showSearchQuery) class="mb-8 flex flex-col space-y-8" @endif>
    @if($showFilters)
        <div>
            <h4 class="font-semibold">{{ __('Filter') }}</h4>
            @foreach($allFilters as $filters)
                <ul class="flex flex-wrap mb-2">
                    @foreach($filters as $key => $filter)
                        @include('laravel-toolbox::_filter-sort-item', [
                            'routeName' => Route::currentRouteName(),
                            'isActive' => $isFilterActive($key),
                            'filter' => $key,
                            'label' => $filter->label,
                            'title' => $filter->title,
                            'filterCount' => $toFilterCount($key),
                            'filtersQuery' => $toFiltersQueryString($key),
                            'sortsQuery' => $toSortsQueryString(),
                            'showDeleteFilterButton' => $key !== \BondarDe\LaravelToolbox\ModelList\ModelFilters::ALL,
                        ])
                    @endforeach
                </ul>
            @endforeach
        </div>
    @endif

    @if($showSorts)
        <div>
            <h4 class="font-semibold">{{ __('Sorting') }}</h4>
            <ul class="flex flex-wrap mb-4">
                @foreach($allSorts as $key => $sort)
                    @include('laravel-toolbox::_filter-sort-item', [
                        'routeName' => Route::currentRouteName(),
                        'isActive' => $isSortActive($key),
                        'label' => $sort->label,
                        'title' => $sort->title,
                        'filtersQuery' => $toFiltersQueryString(),
                        'sortsQuery' => $toSortsQueryString($key),
                    ])
                @endforeach
            </ul>
        </div>
    @endif


    @if($showSearchQuery)
        <form
            method="get"
            action="{{ route(Route::currentRouteName(), [
            'filters' => $toFiltersQueryString(),
            'sort' => $toSortsQueryString(),
        ]) }}"
        >
            <h4 class="font-semibold">{{ __('Search') }}</h4>
            <x-form.input
                name="q"
                placeholder="{{ __('Search query') }}"
                value="{{ $searchQuery }}"
            />
        </form>
    @endif
</div>

@if($items->total() > $items->perPage())
    {!! $links !!}
@endif

<h1>{!! $pageTitle !!}</h1>

@if($items->count())
    <x-content class="overflow-x-auto">
        {{ $slot }}
    </x-content>
@else
    <p class="text-muted mt-5">Keine Einträge zum ausgewählten Filter wurden gefunden.</p>
@endif

@if($items->total() > $items->perPage())
    {!! $links !!}
@endif
