<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use TeamTNT\TNTSearch\TNTSearch;

class SearchHighlightedText extends Component
{
    public function __construct(
        public readonly ?string $q,
        public readonly string  $cssClass = 'search-highlight',
    )
    {
    }

    public function highlight(string $text): string
    {
        $tnt = new TNTSearch();

        return $tnt->highlight($text, $this->q, 'span', [
            'wholeWord' => false,
            'tagOptions' => [
                'class' => 'search-highlight',
            ],
        ]);
    }

    public function render(): View
    {
        return view('lox::components.search-highlighted-text');
    }
}
