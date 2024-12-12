<?php

use BondarDe\Lox\Data\Acl\AclSetupData;
use BondarDe\Lox\Http\Controllers\Admin\Cms\AdminCmsOverviewController;
use BondarDe\Lox\Http\Controllers\Admin\Cms\AdminCmsPagesController;
use BondarDe\Lox\Http\Controllers\Admin\Cms\AdminCmsRedirectsController;
use BondarDe\Lox\Http\Controllers\Admin\Cms\AdminCmsTemplatesController;
use BondarDe\Lox\Http\Controllers\Admin\Cms\Assistant\AdminCmsAssistantIndexController;
use BondarDe\Lox\Http\Controllers\Admin\Cms\Assistant\AdminCmsAssistantStoreController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminAboutController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminCacheController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminEventsController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminPhpInfoController;
use BondarDe\Lox\Http\Controllers\Admin\System\AdminRoutesController;
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
        'middleware' => [
            'can:' . AclSetupData::PERMISSION_EDIT_CMS_PAGES,
        ],
    ], function () {
        Route::group([
            'prefix' => 'cms/',
            'as' => 'cms.',
        ], function () {
            Route::get('/', AdminCmsOverviewController::class)->name('overview');

            Route::resource('pages', AdminCmsPagesController::class)
                ->parameter('pages', 'cms_page')
                ->whereNumber('cms_page');

            Route::resource('redirects', AdminCmsRedirectsController::class)
                ->parameter('redirects', 'cms_redirect');

            Route::get('assistant', AdminCmsAssistantIndexController::class)->name('assistant.index');
            Route::put('assistant', AdminCmsAssistantStoreController::class)->name('assistant.store');

            Route::resource('templates', AdminCmsTemplatesController::class)
                ->parameter('templates', 'cms_template');
        });
    });

    Route::group([
        'prefix' => 'system/',
        'as' => 'system.',
        'middleware' => [
            'can:' . AclSetupData::PERMISSION_VIEW_SYSTEM_STATUS,
        ],
    ], function () {
        Route::get('/', AdminSystemStatusIndexController::class)->name('index');

        Route::get('about', AdminAboutController::class)->name('about');
        Route::get('schedule', AdminScheduleController::class)->name('schedule');
        Route::get('events', AdminEventsController::class)->name('events');
        Route::get('routes', AdminRoutesController::class)->name('routes');
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
