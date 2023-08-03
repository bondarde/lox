<?php

namespace Tests\Surveys;

use BondarDe\Lox\Surveys\ItemValues\Common\StatesAT;
use BondarDe\Lox\Surveys\ItemValues\Common\StatesCH;
use BondarDe\Lox\Surveys\ItemValues\Common\StatesDACH;
use BondarDe\Lox\Surveys\ItemValues\Common\StatesDE;
use BondarDe\Lox\Surveys\SurveyItemValues;
use PHPUnit\Framework\TestCase;

class SurveyItemValuesTest extends TestCase
{
    const KEYS_DE = [
        'de-bw',
        'de-by',
        'de-be',
        'de-bb',
        'de-hb',
        'de-hh',
        'de-he',
        'de-mv',
        'de-ni',
        'de-nw',
        'de-rp',
        'de-sl',
        'de-sn',
        'de-st',
        'de-sh',
        'de-th',
    ];
    const KEYS_AT = [
        'at-1',
        'at-2',
        'at-3',
        'at-4',
        'at-5',
        'at-6',
        'at-7',
        'at-8',
        'at-9',
    ];
    const KEYS_CH = [
        'ch-zh',
        'ch-be',
        'ch-lu',
        'ch-ur',
        'ch-sz',
        'ch-ow',
        'ch-nw',
        'ch-gl',
        'ch-zg',
        'ch-fr',
        'ch-so',
        'ch-bs',
        'ch-bl',
        'ch-sh',
        'ch-ar',
        'ch-ai',
        'ch-sg',
        'ch-gr',
        'ch-ag',
        'ch-tg',
        'ch-ti',
        'ch-vd',
        'ch-vs',
        'ch-ne',
        'ch-ge',
        'ch-ju',
    ];

    public function testKeysGetterForFlatArray()
    {
        self::assertEquals(self::KEYS_DE, StatesDE::keys());
        self::assertEquals(self::KEYS_AT, StatesAT::keys());
        self::assertEquals(self::KEYS_CH, StatesCH::keys());
    }

    public function testKeysGetterForMultidimensionalArray()
    {
        $keys = array_merge(self::KEYS_DE, self::KEYS_AT, self::KEYS_CH);

        self::assertEquals($keys, StatesDACH::keys());
    }

    public function testKeysGetterWithPatternFromFlatArray()
    {
        $keys = [
            'de-bw',
            'de-by',
            'de-be',
            'de-bb',
        ];
        self::assertEquals($keys, StatesDE::keys('de-b*'));
    }

    public function testKeysGetterWithPatternFromMultidimensionalArray()
    {
        $keys = [
            'de-bw',
            'de-by',
            'de-be',
            'de-bb',
        ];
        self::assertEquals($keys, StatesDACH::keys('de-b*'));
    }

    public function testLabelGetterForFlatArray()
    {
        self::assertEquals('Berlin', StatesDE::label('de-be'));
        self::assertEquals('Wien', StatesAT::label('at-9'));
        self::assertEquals('Zürich', StatesCH::label('ch-zh'));
    }

    public function testLabelGetterForMultidimensionalArray()
    {
        self::assertEquals('Berlin', StatesDACH::label('de-be'));
        self::assertEquals('Wien', StatesDACH::label('at-9'));
        self::assertEquals('Zürich', StatesDACH::label('ch-zh'));
    }

    public function testFilteringByKeyPattern()
    {
        $testClass1 = new class extends SurveyItemValues {
            public static function all(): array
            {
                return [
                    'key1' => 'Value 1',
                    'key2' => 'Value 2',
                    'key3' => 'Value 3',
                    'key10' => 'Value 10',
                    'key11' => 'Value 11',
                ];
            }
        };

        $testClass2 = new class extends SurveyItemValues {
            public static function all(): array
            {
                return [
                    'key1' => 'Value 1',
                    'key2' => 'Value 2',
                    'key3' => 'Value 3',
                    'sub1' => [
                        'key10' => 'Value 10',
                        'key11' => 'Value 11',
                    ],
                    'sub2' => [
                        'sub3' => [
                            'key12' => 'Value 12',
                            'key13' => 'Value 13',
                        ],
                        'sub4' => [
                            'key30' => 'Value 30',
                        ],
                    ],
                ];
            }
        };

        self::assertEquals(
            [
                'key1' => 'Value 1',
                'key10' => 'Value 10',
                'key11' => 'Value 11',
            ],
            $testClass1::matching('key1*'),
        );

        self::assertEquals(
            [
                'key1' => 'Value 1',
                'sub1' => [
                    'key10' => 'Value 10',
                    'key11' => 'Value 11',
                ],
                'sub2' => [
                    'sub3' => [
                        'key12' => 'Value 12',
                        'key13' => 'Value 13',
                    ],
                ],
            ],
            $testClass2::matching('key1*'),
        );
    }
}
