<?php

namespace BondarDe\Lox\Livewire\ModelList;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public string $model;
    public bool $isFilterVisible = false;

    public function render(): ?View
    {
        return view('lox::livewire.model-list.filter');
    }
}
