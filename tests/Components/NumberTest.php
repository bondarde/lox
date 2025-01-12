<?php

namespace Tests\Components;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class NumberTest extends TestCase
{
    public function testRenders_1024()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap">1,024</span>

HTML;
        $actual = Blade::render('<x-lox::number number="1024" />');

        self::assertEquals($expected, $actual);
    }

    public function testRendersNegativeNumber()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap">–123,456</span>

HTML;
        $actual = Blade::render('<x-lox::number number="-123456" />');

        self::assertEquals($expected, $actual);
    }

    public function testRendersDecimals()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap">123,456.79</span>

HTML;
        $actual = Blade::render('<x-lox::number number="123456.789" decimals="2" />');

        self::assertEquals($expected, $actual);
    }

    public function testRendersWithAdditionalCssClasses()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap font-semibold">123,456.79</span>

HTML;
        $actual = Blade::render('<x-lox::number number="123456.789" decimals="2" class="font-semibold" />');

        self::assertEquals($expected, $actual);
    }
}
