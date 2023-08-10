<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Models;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\Lox\LoxServiceProvider;

class AdminModelsListController
{
    public function __invoke(string $model)
    {
        $modelMeta = ModelMeta::fromFullyQualifiedClassName($model);

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.models.list', compact(
            'model',
            'modelMeta',
        ));
    }
}
