<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use Illuminate\View\Component;

class InputError extends Component
{
    public function render()
    {
        return view('laravel-components::form.input-error');
    }
}