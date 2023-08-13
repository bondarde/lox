<?php

namespace BondarDe\Lox\Support\Search;

use ReflectionMethod;
use TeamTNT\Scout\Console\StatusCommand;

class DiscoveryUtil
{
    public static function getModels(): array
    {
        $cmd = new StatusCommand();

        $reflectionMethod = new ReflectionMethod($cmd, 'getSearchableModelsFromClasses');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invoke($cmd);
    }
}
