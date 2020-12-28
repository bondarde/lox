<?php

namespace De\Bondar\LaravelComponents\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('laravel-components::form.input');
    }
}
