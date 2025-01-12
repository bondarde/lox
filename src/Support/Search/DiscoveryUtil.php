<?php

namespace BondarDe\Lox\Support\Search;

use BondarDe\Lox\Models\CmsPage;
use ReflectionException;
use ReflectionMethod;
use TeamTNT\Scout\Console\StatusCommand;

class DiscoveryUtil
{
    /**
     * @throws ReflectionException
     */
    public static function getModels(): array
    {
        $command = new StatusCommand();

        $reflectionMethod = new ReflectionMethod($command, 'getSearchableModelsFromClasses');
        /** @noinspection PhpExpressionResultUnusedInspection */
        $reflectionMethod->setAccessible(true);

        $projectModels = $reflectionMethod->invoke($command);

        $loxModels = [
            CmsPage::class,
        ];

        return [
            ...$loxModels,
            ...$projectModels,
        ];
    }
}
