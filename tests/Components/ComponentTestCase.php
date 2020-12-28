<?php

namespace Tests\Components;

use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

abstract class ComponentTestCase extends TestCase
{
    use CreatesApplication;

    protected function compareHtml(string $componentClassName, string $expectedHtml, array $data = [])
    {
        $view = $this->component($componentClassName, $data);
        $actualHtml = $view->__toString();

        self::assertEquals($expectedHtml, $actualHtml);
    }
}
