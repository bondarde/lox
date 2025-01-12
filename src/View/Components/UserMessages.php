<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserMessages extends Component
{
    public function render(): View
    {
        return view('lox::components.user-messages');
    }
}
