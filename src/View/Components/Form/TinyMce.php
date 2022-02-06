<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use Illuminate\View\Component;

class TinyMce extends Component
{
    public string $jsLibSrc;
    public bool $loadJsLib;
    public array $editorConfig;

    public function __construct(
        ?string $selector = null,
        ?array  $config = null,
        string  $src = '/tinymce/tinymce.min.js'
    )
    {
        if (is_null($selector) && is_null($config)) {
            throw new IllegalStateException('Either selector or config is required.');
        }

        $this->editorConfig = $config ?? self::makeConfig($selector);

        if (defined('TOOLBOX_TINY_MCE_LIB_LOADED')) {
            $this->loadJsLib = false;
        } else {
            $this->loadJsLib = true;
            $this->jsLibSrc = $src;
            define('TOOLBOX_TINY_MCE_LIB_LOADED', true);
        }
    }

    private static function makeConfig(string $selector): array
    {
        return [
            'selector' => $selector,
            'plugins' => 'autoresize code wordcount link image',
            'toolbar' => 'undo redo | styleselect | bold italic | link image | code',
            'convert_urls' => false,
            'entity_encoding' => 'raw',
            'width' => '100%',
        ];
    }

    public function render()
    {
        return view('laravel-toolbox::form.tiny-mce');
    }
}
