<?php

namespace Tests\Components\Form;

use BondarDe\LaravelToolbox\View\Components\Form\Boolean;
use Tests\Components\ComponentTestCase;
use Tests\CreatesApplication;

class BooleanTest extends ComponentTestCase
{
    use CreatesApplication;

    public function testBasicTemplateRendering()
    {
        $expected = <<<HTML
<label class="block cursor-pointer">
    <input
        type="checkbox"
        class="form-boolean"
        name="yes-no"
        >
    <span class="align-middle select-none">Please check</span>
</label>

HTML;

        $data = [
            'name' => 'yes-no',
            'label' => 'Please check',
        ];

        $this->compareHtml(Boolean::class, $expected, $data);
    }

    public function testWithModelChecked()
    {
        $expected = <<<HTML
<label class="block cursor-pointer">
    <input
        type="checkbox"
        class="form-boolean"
        name="is_active"
        checked="checked">
    <span class="align-middle select-none">Please check</span>
</label>

HTML;

        $model = [
            'is_active' => true,
        ];
        $model = json_decode(json_encode($model));

        $data = [
            'name' => 'is_active',
            'label' => 'Please check',
            'model' => $model,
        ];

        $this->compareHtml(Boolean::class, $expected, $data);
    }
}
