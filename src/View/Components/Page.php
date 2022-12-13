<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Constants\Environment;
use BondarDe\LaravelToolbox\Contracts\View\PageConfig;
use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use BondarDe\LaravelToolbox\Support\ViteManifestParser;
use Illuminate\View\Component;

class Page extends Component
{
    public string $metaRobots;
    public string $title;

    public array $cssFiles;
    public array $jsFiles;

    protected string $env;

    /**
     * @throws IllegalStateException
     */
    public function __construct(
        readonly protected PageConfig $config,
        readonly public bool          $wrapContent = true,
        readonly public string        $metaDescription = '',
        ?string                       $metaRobots = null,
        ?string                       $title = null,
        readonly public ?string       $h1 = null,
        readonly public bool          $livewire = false,
        public                        $breadcrumbAttr = null,
        readonly public ?string       $shareImage = null,
    )
    {
        $this->env = config('app.env');

        $this->metaRobots = self::toMetaRobots($metaRobots, $this->env);
        $this->title = $title ?? '';

        $this->cssFiles = self::toCssFiles($this->env);
        $this->jsFiles = self::toJsFiles($this->env);
    }

    /**
     * @throws IllegalStateException
     */
    private static function toCssFiles(string $env): array
    {
        if ($env === Environment::LOCAL) {
            return [
                ViteManifestParser::getStylesheetFilePath(),
            ];
        }

        return [
            '/=)/app.' . config('app.version') . '.css',
        ];
    }

    /**
     * @throws IllegalStateException
     */
    private static function toJsFiles(string $env): array
    {
        if ($env === Environment::LOCAL) {
            return [
                ViteManifestParser::getJavascriptFilePath(),
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
        $bodyClasses = $this->config->bodyClasses();
        $contentWrapClasses = $this->config->contentWrapClasses();
        $pageHeaderWrapperClasses = $this->config->pageHeaderWrapperClasses();
        $pageContentWrapperClasses = $this->config->pageContentWrapperClasses();

        return view('laravel-toolbox::page', compact(
            'bodyClasses',
            'contentWrapClasses',
            'pageHeaderWrapperClasses',
            'pageContentWrapperClasses',
        ));
    }
}
