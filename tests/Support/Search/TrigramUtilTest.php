<?php

namespace Tests\Support\Search;

use BondarDe\Lox\Support\Search\TrigramUtil;
use PHPUnit\Framework\TestCase;

class TrigramUtilTest extends TestCase
{
    public function testMakeReturnsNull()
    {
        self::assertNull(TrigramUtil::make(null));
        self::assertNull(TrigramUtil::make(''));
    }

    public function testMake()
    {
        self::assertEquals('__l _lo lox ox_ x__', TrigramUtil::make('lox'));
    }
}
