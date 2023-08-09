<?php

namespace BondarDe\Lox\Livewire\ModelList;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class Search extends Component
{
    #[Url(as: 'q')]
    public string $value = '';

    function updatedValue(): void
    {
        $this->dispatch('live-model-list:search-query-changed', $this->value);
    }

    public function render(): ?View
    {
        return view('lox::livewire.model-list.search');
    }
}
