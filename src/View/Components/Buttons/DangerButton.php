<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

use Illuminate\View\Component;

class DangerButton extends Component
{
    public function render()
    {
        return view('laravel-toolbox::buttons.danger');
    }
}
