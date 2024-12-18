<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class NavItem extends Component
{
    public string $cssClasses;

    public function __construct(
        Request $request,
        public readonly string $href,
        string|array|null $activeRoute = null,
        string|array|null $activePath = null,
        public readonly ?string $info = null,
        public readonly ?string $containerClass = null,
    ) {
        $active = false;
        if ($activeRoute && Route::is($activeRoute)) {
            $active = true;
        }
        if ($activePath && Str::is($activePath, $request->path())) {
            $active = true;
        }

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
        return view('lox::components.nav-item');
    }
}
