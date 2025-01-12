<?php

namespace BondarDe\Lox\Models\Sushi;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;
use Composer\Autoload\ClassLoader;
use Exception;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;
use Sushi\Sushi;

class ApplicationModel extends EloquentModel
{
    use Sushi;

    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows(): array
    {
        return $this->getModels()
            ->values()
            ->map(fn (ModelMeta $meta) => [
                ...(array) $meta,
                'id' => $meta->fullyQualifiedClassName,
            ])
            ->toArray();
    }

    protected function sushiShouldCache(): true
    {
        return true;
    }

    private function getModels(): Collection
    {
        /** @var ClassLoader $loader */
        $loader = require base_path() . '/vendor/autoload.php';
        $classMap = $loader->getClassMap();

        $userModels = config('lox.admin.eloquent_models');

        return (new Collection($classMap))
            ->filter(function ($filepath) use ($userModels) {
                try {
                    $fileContent = File::get($filepath);
                } catch (Exception) {
                    return false;
                }

                return Str::contains($fileContent, $userModels);
            })
            ->keys()
            ->filter(function (string $className) {
                $reflection = new ReflectionClass($className);

                return $reflection->isSubclassOf(EloquentModel::class)
                    && ! $reflection->isAbstract();
            })
            ->sort()
            ->map(fn (string $fullyQualifiedClassName) => ModelMeta::fromFullyQualifiedClassName($fullyQualifiedClassName));
    }
}
