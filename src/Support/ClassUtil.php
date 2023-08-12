<?php

namespace BondarDe\Lox\Support;

class ClassUtil
{
    public static function hasTrait(string $className, string $traitName): bool
    {
        $allClasses = class_uses_recursive($className);

        return isset($allClasses[$traitName]);
    }
}
