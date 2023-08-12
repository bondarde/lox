<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Data;

class ModelMeta
{
    private const SEPARATOR = '\\';

    public function __construct(
        public readonly string $fullyQualifiedClassName,
        public readonly string $namespace,
        public readonly string $className,
    )
    {
    }

    public static function fromFullyQualifiedClassName(string $fullyQualifiedClassName)
    {
        $parts = explode(self::SEPARATOR, $fullyQualifiedClassName);

        $className = array_splice($parts, -1)[0];
        $namespace = implode(self::SEPARATOR, $parts);

        return new self(
            $fullyQualifiedClassName,
            $namespace,
            $className,
        );
    }

    public function htmlLabel(): string
    {
        return '<span class="opacity-50 text-md">'
            . $this->namespace . self::SEPARATOR
            . '</span>'
            . '<span>'
            . $this->className
            . '</span>';
    }

    public function __toString(): string
    {
        return $this->htmlLabel();
    }
}
