<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use Illuminate\View\Component;

class InputError extends Component
{
    public string $for;

    public function __construct(
        string $for
    )
    {
        $this->for = $for;
    }

    public function render()
    {
        return view('laravel-toolbox::form.input-error');
    }
}
