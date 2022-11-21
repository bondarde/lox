<?php

namespace BondarDe\LaravelToolbox\View;

use BondarDe\LaravelToolbox\Contracts\View\PageConfig;

class DefaultPageConfig implements PageConfig
{
    public function bodyClasses(): string
    {
        return 'antialiased overflow-x-hidden bg-gray-50 dark:bg-black text-gray-800 dark:text-gray-100';
    }

    public function contentWrapClasses(): string
    {
        return 'min-h-screen';
    }

    public function pageHeaderWrapperClasses(): string
    {
        return 'container mb-10';
    }

    public function pageContentWrapperClasses(): string
    {
        return 'container mb-10';
    }
}
