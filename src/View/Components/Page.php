<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Constants\Environment;
use Illuminate\View\Component;

class Page extends Component
{
    public bool $wrapContent;
    public string $metaRobots;
    public string $title;
    public ?string $h1 = null;
    public bool $livewire;

    public string $metaDescription = '';
    public array $cssFiles;
    public array $jsFiles;

    private string $env;

    public function __construct(
        bool $wrapContent = true,
        string $metaDescription = '',
        ?string $metaRobots = null,
        ?string $title = null,
        ?string $h1 = null,
        bool $livewire = false
    )
    {
        $this->env = config('app.env');

        $this->metaDescription = $metaDescription;
        $this->metaRobots = self::toMetaRobots($metaRobots, $this->env);
        $this->title = $title ?? '';
        $this->h1 = $h1;
        $this->wrapContent = $wrapContent;

        $this->cssFiles = self::toCssFiles($this->env);
        $this->jsFiles = self::toJsFiles($this->env);
        $this->livewire = $livewire;
    }

    private static function toCssFiles(string $env): array
    {
        if ($env === Environment::LOCAL) {
            return [
                '/css/app.css?t=' . time(),
            ];
        }

        return [
            '/=)/app.' . config('app.version') . '.css',
        ];
    }

    private static function toJsFiles(string $env): array
    {
        if ($env === Environment::LOCAL) {
            return [
                '/js/app.js?t=' . time(),
            ];
        }

        return [
            '/=)/app.' . config('app.version') . '.js',
        ];
    }

    private static function toMetaRobots(?string $metaRobots, string $env): string
    {
        if ($env !== Environment::PROD) {
            return 'noindex, nofollow';
        }

        return $metaRobots ?? 'index, follow';
    }

    public function render()
    {
        return view('laravel-toolbox::page');
    }
}