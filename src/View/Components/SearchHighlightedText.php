<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

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
        $parts = explode(' ', $this->q);

        foreach ($parts as $part) {
            [
                $res,
                $count,
            ] = self::highlightSearchQuery($text, $part, $this->cssClass);

            if ($count) {
                return $res;
            }
        }

        return $text;
    }

    private static function highlightSearchQuery(string $s, string $q, string $cssClass): array
    {
        $s = str_replace($q, '<span class="' . $cssClass . '">' . self::escape($q) . '</span>', $s, $count);
        if ($count) {
            return [$s, $count];
        }
        $s = str_replace(mb_strtolower($q), '<span class="' . $cssClass . '">' . self::escape(mb_strtolower($q)) . '</span>', $s, $count);
        if ($count) {
            return [$s, $count];
        }
        $s = str_replace(mb_strtoupper($q), '<span class="' . $cssClass . '">' . self::escape(mb_strtoupper($q)) . '</span>', $s, $count);
        if ($count) {
            return [$s, $count];
        }
        $s = str_replace(ucwords($q), '<span class="' . $cssClass . '">' . self::escape(ucwords($q)) . '</span>', $s, $count);

        return [$s, $count];
    }

    private static function escape(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    public function render(): View
    {
        return view('lox::search-highlighted-text');
    }
}
