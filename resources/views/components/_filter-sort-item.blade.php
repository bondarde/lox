<li title="{{ $title ?? $label }}">
    @if($isActive)
        <span class="p-1 shadow rounded bg-yellow-50 dark:bg-yellow-50/30">
            {{ $label }}
            @isset($filterCount)
                <x-lox::number
                    class="text-sm opacity-50"
                    :number="$filterCount"
                />
            @endisset
            @if($showDeleteFilterButton ?? false)
                <a
                    class="ml-1 text-red-700"
                    href="{{ route($routeName, [
                        ...$routeParams,
                        'filters' => $filtersQuery,
                        'sort' => $sortsQuery,
                        'q' => $searchQuery,
                    ]) }}"
                >×</a>
            @endif
        </span>
    @else
        <a
            @class([
                'p-1 group',
                'opacity-50' => isset($filterCount) && $filterCount === 0,
            ])
            href="{{ route($routeName, [
                ...$routeParams,
                'filters' => $filtersQuery,
                'sort' => $sortsQuery,
                'q' => $searchQuery,
            ]) }}"
        >
            <span
                class="group-hover:underline"
            >{{ $label }}</span>
            @isset($filterCount)
                <x-lox::number
                    class="text-sm opacity-50"
                    :number="$filterCount"
                    zero=""
                />
            @endisset
        </a>
    @endif
</li>
