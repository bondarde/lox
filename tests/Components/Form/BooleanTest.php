<?php

namespace Tests\Components\Form;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class BooleanTest extends TestCase
{
    public function testBasicTemplateRendering()
    {
        $expected = <<<HTML
<label class="flex gap-2 cursor-pointer">
    <input
        class="form-boolean"
        type="checkbox"
        name="yes-no"
        
    >
    <span class="align-middle select-none grow">Please check</span>
</label>

HTML;
        $actual = Blade::render('<x-lox::form.boolean name="yes-no">Please check</x-lox::form.boolean>');

        self::assertEquals($expected, $actual);
    }

    public function testWithModelChecked()
    {
        $expected = <<<HTML
<label class="flex gap-2 cursor-pointer">
    <input
        class="form-boolean"
        type="checkbox"
        name="is_active"
        checked="checked"
    >
    <span class="align-middle select-none grow">Please check</span>
</label>

HTML;

        $model = [
            'is_active' => true,
        ];
        $model = json_decode(json_encode($model));

        $actual = Blade::render('<x-lox::form.boolean name="is_active" :model="$model">Please check</x-lox::form.boolean>', compact('model'));

        self::assertEquals($expected, $actual);
    }
}
