<?php

namespace BondarDe\LaravelToolbox\View\Components;

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

    public function render()
    {
        return view('laravel-toolbox::validation-errors');
    }
}
