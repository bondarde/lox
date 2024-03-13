<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlHeader extends Component
{
    public function __construct(
        readonly public ?string $title = null,
        readonly public ?string $shareImage = null,
        readonly public ?string $metaDescription = null,
    )
    {
    }

    public function render(): View
    {
        return view('lox::html-header');
    }
}
