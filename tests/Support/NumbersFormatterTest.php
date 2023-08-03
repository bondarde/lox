<?php

namespace Tests\Support;

use BondarDe\Lox\Support\NumbersFormatter;
use Tests\TestCase;

class NumbersFormatterTest extends TestCase
{
    public function testFormatsInteger()
    {
        $res = NumbersFormatter::format(1234);

        self::assertEquals('1,234', $res);
    }

    public function testFormatsFloat()
    {
        $res = NumbersFormatter::format(1234.5678, 2);

        self::assertEquals('1,234.57', $res);
    }

    public function testFormatGerman()
    {
        config()->set('app.locale', 'de');
        $res = NumbersFormatter::format(1234.456, 2);

        self::assertEquals('1.234,46', $res);
    }
}
