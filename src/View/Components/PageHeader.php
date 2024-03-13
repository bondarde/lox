<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    public function render(): View
    {
        return view('lox::page-header');
    }
}
