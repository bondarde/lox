<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ValidationErrors extends Component
{
    public int $limit = 5;

    public function __construct(
        int $limit = 5
    )
    {
        $this->limit = $limit;
    }

    public function render(): View
    {
        return view('lox::components.validation-errors');
    }
}
