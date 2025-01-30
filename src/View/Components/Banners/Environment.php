<?php

namespace BondarDe\Lox\View\Components\Banners;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Environment extends Component
{
    public function render(): ?View
    {
        if (App::environment(\BondarDe\Lox\Constants\Environment::PROD)) {
            return null;
        }

        $label = ucfirst(App::environment());

        return view('lox::components.banners.environment', compact(
            'label',
        ));
    }
}
