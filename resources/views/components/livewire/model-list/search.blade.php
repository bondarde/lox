<form>
    <x-lox::form.input
        wire:model.live.debounce="value"
        :name="BondarDe\Lox\Livewire\LiveModelList::URL_PARAM_SEARCH_QUERY"
        placeholder="Search"
    />
</form>
