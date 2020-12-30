<?php

namespace BondarDe\LaravelToolbox\View\Components;

use Illuminate\View\Component;

class ValidationErrors extends Component
{
    public function render()
    {
        return view('laravel-toolbox::validation-errors');
    }
}
