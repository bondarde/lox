<?php

namespace BondarDe\Lox\ModelList;

use BondarDe\Lox\Exceptions\InvalidModelSortException;
use Closure;
use ReflectionException;
use ReflectionFunction;

class ModelSort
{
    /**
     * @throws ReflectionException
     * @throws InvalidModelSortException
     */
    public function __construct(
        public readonly string  $label,
        public readonly Closure $sql,
        public ?string          $title = null,
    )
    {
        $this->title = $title ?? $label;

        self::validateCallback($sql);
    }

    /**
     * @throws ReflectionException
     * @throws InvalidModelSortException
     */
    private static function validateCallback(Closure $callback): void
    {
        $reflection = new ReflectionFunction($callback);
        $parameters = $reflection->getParameters();

        if (count($parameters) !== 2) {
            throw new InvalidModelSortException('Sorting direction must be accepted by sorting method.');
        }
    }
}
