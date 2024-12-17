<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Data;

use Exception;
use Illuminate\Database\Eloquent\Model;

readonly class ModelMeta
{
    private const string SEPARATOR = '\\';

    public function __construct(
        public string $fullyQualifiedClassName,
        public string $namespace,
        public string $className,
        public string $dbTableName,
        public int $dbEntriesCount,
    ) {
        //
    }

    public static function fromFullyQualifiedClassName(string $fullyQualifiedClassName)
    {
        $parts = explode(self::SEPARATOR, $fullyQualifiedClassName);

        $className = array_splice($parts, -1)[0];
        $namespace = implode(self::SEPARATOR, $parts);

        /** @var Model $model */
        $model = new $fullyQualifiedClassName();
        $dbTableName = $model->getTable();
        try {
            $dbEntriesCount = $model::count();
        } catch (Exception) {
            $dbEntriesCount = 0;
        }

        return new self(
            $fullyQualifiedClassName,
            $namespace,
            $className,
            $dbTableName,
            $dbEntriesCount,
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
