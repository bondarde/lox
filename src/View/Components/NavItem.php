<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class NavItem extends Component
{
    public string $cssClasses;

    public function __construct(
        public readonly string  $href,
        string|array            $activeRoute,
        public readonly ?string $info = null,
        public readonly ?string $containerClass = null,
    )
    {
        $active = Route::is($activeRoute);

        $baseClasses = 'relative after:absolute after:block after:h-1 after:-bottom-1 after:transition-all after:-skew-x-12';
        $hoverClasses = 'hover:after:left-0 hover:after:w-full hover:after:bg-nav-highlight';
        $inactiveClasses = 'after:left-1/2 after:w-0 after:bg-nav-highlight';
        $activeClasses = 'after:left-0 after:w-full after:bg-nav-highlight/75';

        $this->cssClasses = collect([
            $baseClasses,
            $hoverClasses,
            $active ? $activeClasses : $inactiveClasses,
        ])->filter()->join(' ');
    }

    public function render(): View
    {
        return view('lox::nav-item');
    }
}
