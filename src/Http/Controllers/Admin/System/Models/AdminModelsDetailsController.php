<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Models;

use BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdminModelsDetailsController
{
    public function __invoke(string $model, string|int $id)
    {
        $modelMeta = ModelMeta::fromFullyQualifiedClassName($model);
        /** @var Model $model */
        $modelInstance = $model::find($id);

        $pageTitle = $modelMeta->className . ' ' . $id;

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.models.details', compact(
            'model',
            'id',
            'modelMeta',
            'modelInstance',
            'pageTitle',
        ));
    }
}
