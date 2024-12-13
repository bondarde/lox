<?php

use BondarDe\Lox\Data\Acl\AclSetupData;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminCacheController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminEventsController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminPhpInfoController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminScheduleController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminSearchStatusController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminSystemStatusIndexController;
use BondarDe\Lox\Http\Controllers\Admin\System\Database\AdminDatabaseStatusIndexController;
use BondarDe\Lox\Http\Controllers\Admin\System\Database\AdminDatabaseStatusTableController;
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

        Route::get('schedule', AdminScheduleController::class)->name('schedule');
        Route::get('events', AdminEventsController::class)->name('events');
        Route::get('cache', AdminCacheController::class)->name('cache');
        Route::get('php-info', AdminPhpInfoController::class)->name('php-info');
        Route::get('search-status', AdminSearchStatusController::class)->name('search-status');

        Route::get('database', AdminDatabaseStatusIndexController::class)->name('database.index');
        Route::get('database/table:{table}', AdminDatabaseStatusTableController::class)->name('database.table');

        Route::get('models', AdminModelsIndexController::class)->name('models.index');
        Route::get('models/{model}', AdminModelsListController::class)->name('models.list');
        Route::get('models/{model}/{id}', AdminModelsDetailsController::class)->name('models.details');
    });
});
