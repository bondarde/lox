<?php

namespace BondarDe\Lox\View\Components;

use Filament\Support\Assets\AssetManager;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlHeader extends Component
{
    public function __construct(
        readonly public ?string $title = null,
        readonly public ?string $shareImage = null,
        readonly public ?string $metaDescription = null,
    ) {
        //
    }

    protected static function cssVariables(): string
    {
        /** @var AssetManager $assetManager */
        $assetManager = app(AssetManager::class);
        $cssVariables = $assetManager->getCssVariables();

        foreach (FilamentColor::getColors() as $name => $shades) {
            foreach ($shades as $shade => $color) {
                $cssVariables["{$name}-{$shade}"] = $color;
            }
        }

        return view('filament::assets', [
            'assets' => [],
            'cssVariables' => $cssVariables,
        ])->render();
    }

    public function render(): View
    {
        $cssVariables = self::cssVariables();

        return view('lox::components.html-header', compact(
            'cssVariables',
        ));
    }
}
