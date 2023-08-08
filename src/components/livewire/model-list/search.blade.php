<?php

use BondarDe\Lox\Livewire\LiveModelList;

?>
<form
        wire:submit="updateSearchQuery"
>
    <x-form.input
            wire:model="value"
            wire:change.debounce="updateSearchQuery"
            :name="LiveModelList::URL_PARAM_SEARCH_QUERY"
            placeholder="Search"
    />
</form>
