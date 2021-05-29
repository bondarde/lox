<li class="mr-4" @if(isset($title)) title="{{ $title }}" @endif>
    @if($isActive)
        <span class="p-1 shadow bg-yellow-50">
            {{ $label }}
            @isset($filterCount)
                <small class="opacity-50">{{ $filterCount }}</small>
            @endisset
            @if($showDeleteFilterButton ?? false)
                <a class="ml-1 text-red-700"
                   href="{{ route($routeName, [
                        'filters' => $filtersQuery,
                        'sort' => $sortsQuery,
                    ]) }}">×</a>
            @endif
        </span>
    @else
        <a class="p-1 @if(isset($filterCount) && $filterCount === 0) opacity-50 @endif"
           href="{{ route($routeName, [
            'filters' => $filtersQuery,
            'sort' => $sortsQuery,
        ]) }}">
            {{ $label }}
            @isset($filterCount)
                <small class="opacity-50">{{ $filterCount }}</small>
            @endisset
        </a>
    @endif
</li>
