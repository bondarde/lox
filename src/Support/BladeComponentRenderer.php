<?php

namespace BondarDe\Lox\Support;

use BondarDe\Lox\Exceptions\IllegalStateException;
use Illuminate\Contracts\View\View;
use ReflectionClass;
use ReflectionException;

class BladeComponentRenderer
{
    /**
     * Renders a blade component.
     *
     * @param string $componentClassName Component class name
     * @param array $props Component properties
     * @param array $attr Component attributes
     * @return View
     * @throws ReflectionException|IllegalStateException
     */
    public static function render(
        string $componentClassName,
        array  $props = [],
        array  $attr = []
    ): View
    {
        if (!class_exists($componentClassName)) {
            $message = 'Blade component class not found: "' . $componentClassName . '"';

            throw new IllegalStateException($message);
        }

        $reflection = (new ReflectionClass($componentClassName))->getConstructor();
        $params = [];
        foreach ($reflection->getParameters() as $param) {
            $params[] = $props[$param->name] ?? $param->getDefaultValue();
        }
        $component = new $componentClassName(...$params);
        $component->withAttributes($attr);

        return $component->render()->with($component->data());
    }
}
