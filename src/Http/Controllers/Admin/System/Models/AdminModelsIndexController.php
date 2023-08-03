<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Models;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class AdminModelsIndexController
{
    public function __invoke()
    {
        $models = $this->getModels();

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.models.index', compact(
            'models',
        ));
    }

    /**
     * @link https://stackoverflow.com/a/34054171
     *
     * @return Collection<ModelMeta>
     */
    function getModels(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $namespace = Container::getInstance()->getNamespace();
                $className = strtr(substr($path, 0, strrpos($path, '.')), '/', '\\');

                return sprintf('\%s%s', $namespace, $className);
            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        return $models
            ->map(fn(string $fullyQualifiedClassName) => ModelMeta::fromFullyQualifiedClassName($fullyQualifiedClassName));
    }
}
