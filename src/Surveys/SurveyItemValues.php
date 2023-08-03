<?php

namespace BondarDe\Lox\Surveys;

use BondarDe\Utils\Support\Arrays;
use Illuminate\Support\Str;

abstract class SurveyItemValues
{
    abstract public static function all(): array;

    private static function flatAll(): array
    {
        $res = [];
        $flattened = Arrays::flattenKeys(static::all());

        foreach ($flattened as $key => $value) {
            $parts = explode('.', $key);
            $key = last($parts);

            $res[$key] = $value;
        }

        return $res;
    }

    public static function keys(string $pattern = '*'): array
    {
        $keys = array_keys(self::flatAll());
        $keys = array_filter($keys, fn($key) => Str::is($pattern, $key));

        return $keys;
    }

    public static function label(?string $key): string
    {
        if ($key === null) {
            return '—';
        }

        $all = self::flatAll();

        if (!isset($all[$key])) {
            return $key;
        }

        return $all[$key];
    }

    public static function matching(string $keyPattern): array
    {
        return self::matchingInternal($keyPattern, static::all());
    }

    private static function matchingInternal(string $keyPattern, array $arr): array
    {
        $res = [];

        foreach ($arr as $key => $val) {
            if (gettype($val) === 'array') {
                $subRes = self::matchingInternal($keyPattern, $val);
                if (count($subRes)) {
                    $res[$key] = $subRes;
                }
            } else {
                if (Str::is($keyPattern, $key)) {
                    $res[$key] = $val;
                }

            }
        }

        return $res;
    }

    public static function without(array $missingOptions): array
    {
        $res = [];

        foreach (static::all() as $key => $val) {
            if (in_array($key, $missingOptions)) {
                continue;
            }

            $res[$key] = $val;
        }

        return $res;
    }
}
