<?php

namespace Tests\Components\Form;

use Illuminate\Support\Facades\Blade;
use Illuminate\View\ViewException;
use Tests\TestCase;

class InputTest extends TestCase
{
    public function testFailsWithoutName()
    {
        $this->expectException(ViewException::class);

        Blade::render('<x-lox::form.input />');
    }

    public function testBasicTemplateRendering()
    {
        $expected = <<<HTML
<label
    class="flex overflow-hidden rounded-md shadow-sm border ring ring-transparent dark:border-gray-700 focus-within:border-blue-300 dark:focus-within:border-blue-700 focus-within:ring-blue-100 dark:focus-within:ring-blue-900"
>
        <input
        type="text" name="test-name" class="grow border-none outline-none p-2 dark:bg-gray-800" id="form-input-test-name" placeholder="" autocomplete="off"
        />
    </label>

HTML;
        $actual = Blade::render('<x-lox::form.input name="test-name" />');

        self::assertEquals($expected, $actual);
    }
}
