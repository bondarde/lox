<?php

namespace BondarDe\LaravelToolbox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class NavItem extends Component
{
    public string $cssClasses;

    public function __construct(
        public readonly string  $href,
        string|array            $activeRoute,
        public readonly ?string $info = null
    )
    {
        $active = Route::is($activeRoute);

        $baseClasses = 'relative after:absolute after:block after:h-1 after:-bottom-1 after:transition-all after:-skew-x-12';
        $hoverClasses = 'hover:after:left-0 hover:after:w-full hover:after:bg-brand';
        $inactiveClasses = 'after:left-1/2 after:w-0 after:bg-brand';
        $activeClasses = 'after:w-full after:bg-brand/50';

        $this->cssClasses = collect([
            $baseClasses,
            $hoverClasses,
            $active ? $activeClasses : $inactiveClasses,
        ])->filter()->join(' ');
    }

    public function render(): View
    {
        return view('laravel-toolbox::nav-item');
    }
}
