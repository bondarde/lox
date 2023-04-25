<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Models;

use BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdminModelsListController
{
    public function __invoke(string $model)
    {
        $modelMeta = ModelMeta::fromFullyQualifiedClassName($model);

        /** @var Model $model */
        $firstModel = $model::query()->first();
        $attributes = array_keys($firstModel?->getAttributes() ?? []);

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.models.list', compact(
            'model',
            'modelMeta',
            'attributes',
        ));
    }
}
