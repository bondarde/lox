<div>
    <h2>{{ $pageTitle }}</h2>

    <x-content
            padding=""
    >
        @if($showFilters || $showSearchQuery)
            <div class="flex gap-4 p-4">
                <div class="grow">
                    @if($showSearchQuery)
                        <livewire:model-list.search
                                :value="$searchQuery"
                        />
                    @endif
                </div>
                <div>
                    @if($showFilters)
                        <livewire:model-list.filter
                                :model="$model"
                        />
                    @endif
                </div>
            </div>
        @endif

        <livewire:model-list.content
                :$searchQuery
                :$items
                :pagination="$links"
                key="{{ Str::random() }}"
        />
    </x-content>
</div>
