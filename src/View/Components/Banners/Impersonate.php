<?php

namespace BondarDe\Lox\View\Components\Banners;

use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Impersonate extends Component
{
    public function __construct(
        private readonly ?string $name = null,
    ) {
        //
    }

    public function render(): ?View
    {
        if (! app('impersonate')->isImpersonating()) {
            return null;
        }
        $name = $this->name ?? Filament::getUserName(Filament::auth()->user());

        return view('lox::components.banners.impersonate', compact(
            'name',
        ));
    }
}
