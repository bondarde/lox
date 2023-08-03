<?php

namespace BondarDe\Lox\Contracts\View;

interface PageConfig
{
    public function bodyClasses(): string;

    public function contentWrapClasses(): string;

    public function pageHeaderWrapperClasses(): string;

    public function pageContentWrapperClasses(): string;
}
