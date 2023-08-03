<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TinyMce extends Component
{
    public string $jsLibSrc;
    public bool $loadJsLib;
    public array $editorConfig;
    public bool $enableImageUpload;
    public string $imagesUploadUrl;

    public function __construct(
        string $selector,
        array  $config = [],
        bool   $enableImageUpload = false,
        string $imagesUploadUrl = '/tinymce-upload',
        string $src = '/tinymce/tinymce.min.js'
    )
    {
        $this->editorConfig = self::makeConfig($selector, $config);

        if (defined('LOX_TINY_MCE_LIB_LOADED')) {
            $this->loadJsLib = false;
        } else {
            $this->loadJsLib = true;
            $this->jsLibSrc = $src;
            define('LOX_TINY_MCE_LIB_LOADED', true);
        }
        $this->enableImageUpload = $enableImageUpload;
        $this->imagesUploadUrl = $imagesUploadUrl;
    }

    private static function makeConfig(
        string $selector,
        array  $config
    ): array
    {
        return array_merge([
            'selector' => $selector,
            'plugins' => 'autoresize code wordcount link image',
            'toolbar' => 'undo redo | styleselect | bold italic | link image | code',
            'convert_urls' => false,
            'entity_encoding' => 'raw',
            'width' => '100%',
            'language' => app()->getLocale(),
        ], $config);
    }

    public function render(): View
    {
        return view('lox::form.tiny-mce');
    }
}
