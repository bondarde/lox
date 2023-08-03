<?php

namespace BondarDe\Lox\Support\ModelList;

use BondarDe\Lox\ModelList\ModelFilters;

class ModelListUrlQueryUtil
{
    public static function toQueryString(array $filters): string
    {
        $filtersCount = count($filters);

        if ($filtersCount > 1) {
            $filters = self::removeByValue($filters, ModelFilters::ALL);
        }

        return implode(',', $filters);
    }

    public static function toFilterIndex(array $filters, string $filter)
    {
        $res = array_search($filter, $filters, true);

        if ($res === false) {
            return -1;
        }

        return $res;
    }

    public static function merge(array $arr1, array $arr2): array
    {
        return array_merge($arr1, $arr2);
    }

    public static function removeByValue(array $filters, string $value): array
    {
        $idx = self::toFilterIndex($filters, $value);

        if ($idx < 0) {
            return $filters;
        }

        return self::removeByIdx($filters, $idx);
    }

    public static function removeByIdx(array $filters, int $idx): array
    {
        $filtersCopy = self::merge($filters, []);
        array_splice($filtersCopy, $idx, 1);

        return $filtersCopy;
    }
}
