<?php

namespace BondarDe\LaravelToolbox\SurveyItemValues;

use Illuminate\Support\Str;

abstract class SurveyItemValues
{
    abstract public static function all(): array;

    public static function keys(): array
    {
        return array_keys(static::all());
    }

    public static function label(?string $key): string
    {
        if ($key === null) {
            return '—';
        }

        $all = static::all();

        if (!isset($all[$key])) {
            return $key;
        }

        return $all[$key];
    }

    public static function matching(string $pattern): array
    {
        $res = [];

        foreach (static::all() as $key => $val) {
            if (!Str::is($pattern, $key)) {
                continue;
            }

            $res[$key] = $val;
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
