<?php

namespace Tests\Components;

use De\Bondar\LaravelComponents\View\Components\Form\Input;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

abstract class ComponentTestCase extends TestCase
{
    use CreatesApplication;

    protected function compareHtml(string $expectedHtml, array $data = [])
    {
        $view = $this->component(Input::class, $data);
        $actualHtml = $view->__toString();

        self::assertEquals($expectedHtml, $actualHtml);
    }
}
