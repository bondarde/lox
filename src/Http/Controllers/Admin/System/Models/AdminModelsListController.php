<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Models;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdminModelsListController
{
    public function __invoke(string $model)
    {
        $modelMeta = ModelMeta::fromFullyQualifiedClassName($model);

        /** @var Model $model */
        $firstModel = $model::query()->first();
        $attributes = array_keys($firstModel?->getAttributes() ?? []);

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.models.list', compact(
            'model',
            'modelMeta',
            'attributes',
        ));
    }
}
