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
                        <x-button
                            color="light"
                            wire:click="$toggle('isFilterPanelVisible')"
                        >
                            🌪️
                            {{-- TODO: badge if any active --}}
                        </x-button>
                    @endif
                </div>
            </div>
            @if($isFilterPanelVisible)
                <div class="p-4 border-t">
                    <livewire:model-list.filter
                        :$model
                        :$searchQuery
                        key="{{ Str::random() }}"
                    />
                </div>
            @endif
        @endif

        <livewire:model-list.content
            :$searchQuery
            :$items
            :pagination="$links"
            key="{{ Str::random() }}"
        />
    </x-content>
</div>
