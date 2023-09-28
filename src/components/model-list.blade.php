<div
    @class([
        'mb-8 flex flex-col space-y-8' => $showFilters || $showSorts || $showSearchQuery,
    ])
>
    @if($showFilters)
        <div>
            <h4 class="font-semibold">{{ __('Filter') }}</h4>
            @foreach($allFilters as $filters)
                <ul class="flex flex-wrap mb-3 -mx-1 gap-x-4 gap-y-1">
                    @foreach($filters as $key => $filter)
                        @include('lox::_filter-sort-item', [
                            'routeName' => $routeName,
                            'routeParams' => $routeParams,
                            'isActive' => $isFilterActive($key),
                            'filter' => $key,
                            'label' => $filter->label,
                            'title' => $filter->title,
                            'filterCount' => $toFilterCount($key),
                            'filtersQuery' => $toFiltersQueryString($key),
                            'sortsQuery' => $toSortsQueryString(),
                            'searchQuery' => $searchQuery,
                            'showDeleteFilterButton' => $key !== \BondarDe\Lox\ModelList\ModelFilters::ALL,
                        ])
                    @endforeach
                </ul>
            @endforeach
        </div>
    @endif

    @if($showSearchQuery)
        <form
            method="get"
            action="{{ route(
                $routeName,
                $routeParams,
            ) }}"
        >
            <input type="hidden" name="filters" value="{{ $toFiltersQueryString() }}">
            <input type="hidden" name="sort" value="{{ $toSortsQueryString() }}">

            <h4 class="font-semibold">{{ __('Search') }}</h4>
            <x-form.input
                name="q"
                placeholder="{{ __('Search query') }}"
                value="{{ $searchQuery }}"
            />
        </form>
    @endif
</div>

<h1>{!! ucfirst($pageTitle) !!}</h1>

{!! $links !!}

@if($items->count())
    <x-content class="overflow-x-auto">
        {{ $slot }}
    </x-content>
@else
    <p class="text-muted mt-5">Keine Einträge zum ausgewählten Filter wurden gefunden.</p>
@endif

{!! $links !!}
