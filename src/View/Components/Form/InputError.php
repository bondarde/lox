<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;
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

    public function render(): View
    {
        return view('lox::form.input-error');
    }
}
