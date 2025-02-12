<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
{
    public function __construct(
        public readonly string $tag = 'div',
        public readonly string $padding = 'p-4',
        public readonly string $margin = 'mb-8',
        public readonly string $background = 'bg-white dark:bg-gray-900',
        public readonly string $shadow = 'shadow',
        public readonly string $rounded = 'rounded-lg',
    ) {
        //
    }

    public function render(): View
    {
        return view('lox::components.content');
    }
}
