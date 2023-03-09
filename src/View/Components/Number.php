<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Support\NumbersFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Number extends Component
{
    public function __construct(
        public readonly float|int $number,
        public readonly int       $decimals = 0,
        public readonly ?string   $suffix = null
    )
    {
    }

    public function render(): View
    {
        $formatted = NumbersFormatter::format(
            $this->number,
            $this->decimals,
            $this->suffix,
        );

        return view('laravel-toolbox::number', compact(
            'formatted',
        ));
    }
}
