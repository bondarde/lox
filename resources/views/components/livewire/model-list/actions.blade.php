<div
    class="p-4 border-y flex flex-wrap gap-4"
>
    @foreach($actions as $idx => $action)
        <x-lox::button
            :enabled="count($selectedPrimaryKeys) > 0"
            wire:click="performAction({{ $idx }})"
        >
            {{ $action->label }}
            ({{ count($selectedPrimaryKeys) }})
        </x-lox::button>
    @endforeach
</div>
