<li class="mr-4" @if(isset($title)) title="{{ $title }}" @endif>
    @if($isActive)
        <span class="p-1 shadow bg-yellow-50">
            {{ $label }}
            @isset($filterCount)
                <x-number
                    class="text-sm opacity-50"
                    :number="$filterCount"
                />
            @endisset
            @if($showDeleteFilterButton ?? false)
                <a class="ml-1 text-red-700"
                   href="{{ route($routeName, [
                        'filters' => $filtersQuery,
                        'sort' => $sortsQuery,
                        'q' => $searchQuery,
                    ]) }}">×</a>
            @endif
        </span>
    @else
        <a class="p-1 @if(isset($filterCount) && $filterCount === 0) opacity-50 @endif"
           href="{{ route($routeName, [
            'filters' => $filtersQuery,
            'sort' => $sortsQuery,
            'q' => $searchQuery,
        ]) }}">
            {{ $label }}
            @isset($filterCount)
                <x-number
                    class="text-sm opacity-50"
                    :number="$filterCount"
                />
            @endisset
        </a>
    @endif
</li>
