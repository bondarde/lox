<?php

use BondarDe\Lox\Data\Acl\AclSetupData;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminSystemStatusIndexController;
use BondarDe\Lox\Http\Controllers\Admin\System\Models\AdminModelsDetailsController;
use BondarDe\Lox\Http\Controllers\Admin\System\Models\AdminModelsIndexController;
use BondarDe\Lox\Http\Controllers\Admin\System\Models\AdminModelsListController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'web',
        'auth:web',
        'verified',
    ],
    'prefix' => 'admin/',
    'as' => 'admin.',
], function () {
    Route::group([
        'prefix' => 'system/',
        'as' => 'system.',
        'middleware' => [
            'can:' . AclSetupData::PERMISSION_VIEW_SYSTEM_STATUS,
        ],
    ], function () {
        Route::get('/', AdminSystemStatusIndexController::class)->name('index');

        Route::get('models', AdminModelsIndexController::class)->name('models.index');
        Route::get('models/{model}', AdminModelsListController::class)->name('models.list');
        Route::get('models/{model}/{id}', AdminModelsDetailsController::class)->name('models.details');
    });
});
