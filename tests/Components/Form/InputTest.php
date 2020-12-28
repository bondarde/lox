<?php

namespace Tests\Components\Form;

use Tests\Components\ComponentTestCase;

class InputTest extends ComponentTestCase
{
    public function testBasicTemplateRendering()
    {
        $expected = <<<HTML
<input>

HTML;

        $this->compareHtml($expected);
    }
}
