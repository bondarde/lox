<?php

namespace Tests\Components;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class FileSizeTest extends TestCase
{
    public function test_renders_100_bytes_without_formatting()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap" title="100 bytes">100</span>
B

HTML;
        $actual = Blade::render('<x-file-size bytes="100" />');

        self::assertEquals($expected, $actual);
    }
    public function test_renders_1024_bytes_binary()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap" title="1,024 bytes">1.00</span>
KiB

HTML;
        $actual = Blade::render('<x-file-size bytes="1024" />');

        self::assertEquals($expected, $actual);
    }

    public function test_renders_gigabytes_binary()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap" title="1,082,949,632 bytes">1,032.78</span>
GiB

HTML;
        $actual = Blade::render('<x-file-size bytes="1082949632" />');

        self::assertEquals($expected, $actual);
    }

    public function test_renders_1024_bytes_decimal()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap" title="1,024 bytes">1.02</span>
KB

HTML;
        $actual = Blade::render('<x-file-size bytes="1024" :binary="false" />');

        self::assertEquals($expected, $actual);
    }

    public function testRendersWithAdditionalCssClasses()
    {
        $expected = <<<HTML
<span class="whitespace-nowrap text-sm" title="1,024 bytes">1.00</span>
KiB

HTML;
        $actual = Blade::render('<x-file-size bytes="1024" class="text-sm" />');

        self::assertEquals($expected, $actual);
    }
}
