<div class="relative">
    <x-button
            color="light"
            wire:click="$toggle('isFilterVisible')"
    >
        🌪️
    </x-button>

    @if($isFilterVisible)
        <x-content
                class="absolute right-0"
        >
            [filters]
        </x-content>
    @endif
</div>
