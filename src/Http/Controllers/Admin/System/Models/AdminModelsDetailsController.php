<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Models;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdminModelsDetailsController
{
    public function __invoke(string $model, string|int $id)
    {
        $modelMeta = ModelMeta::fromFullyQualifiedClassName($model);
        /** @var Model $model */
        $modelInstance = $model::find($id);

        $pageTitle = $modelMeta->className . ' ' . $id;

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.models.details', compact(
            'model',
            'id',
            'modelMeta',
            'modelInstance',
            'pageTitle',
        ));
    }
}
