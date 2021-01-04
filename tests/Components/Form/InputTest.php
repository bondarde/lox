<?php

namespace Tests\Components\Form;

use BondarDe\LaravelToolbox\View\Components\Form\Input;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Components\ComponentTestCase;

class InputTest extends ComponentTestCase
{
    public function testFailsWithoutName()
    {
        $this->expectException(BindingResolutionException::class);
        $this->compareHtml(Input::class, '');
    }

    public function testBasicTemplateRendering()
    {
        $expected = <<<HTML
<label
    class="flex overflow-hidden rounded-md shadow-sm border ring-4 ring-transparent focus-within:border-blue-300 focus-within:ring-blue-100"
>
        <input
        type="text" name="test-name" class="flex-grow border-none outline-none p-2" id="form-input-test-name" placeholder="" autocomplete="off"
        />
    </label>

HTML;

        $data = [
            'name' => 'test-name',
        ];

        $this->compareHtml(Input::class, $expected, $data);
    }
}
