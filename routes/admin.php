<?php

use BondarDe\Lox\Data\Acl\AclSetupData;
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
use BondarDe\Lox\Http\Controllers\Admin\UserPermissions\AdminPermissionIndexController;
use BondarDe\Lox\Http\Controllers\Admin\UserPermissions\AdminPermissionShowController;
use BondarDe\Lox\Http\Controllers\Admin\UserRoles\AdminUserRoleCreateController;
use BondarDe\Lox\Http\Controllers\Admin\UserRoles\AdminUserRoleEditController;
use BondarDe\Lox\Http\Controllers\Admin\UserRoles\AdminUserRoleIndexController;
use BondarDe\Lox\Http\Controllers\Admin\UserRoles\AdminUserRoleShowController;
use BondarDe\Lox\Http\Controllers\Admin\UserRoles\AdminUserRoleStoreController;
use BondarDe\Lox\Http\Controllers\Admin\UserRoles\AdminUserRoleUpdateController;
use BondarDe\Lox\Http\Controllers\Admin\Users\AdminUserEditController;
use BondarDe\Lox\Http\Controllers\Admin\Users\AdminUserIndexController;
use BondarDe\Lox\Http\Controllers\Admin\Users\AdminUserShowController;
use BondarDe\Lox\Http\Controllers\Admin\Users\AdminUserUpdateController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'web',
        'auth:sanctum',
        'verified',
    ],
    'prefix' => 'admin/',
    'as' => 'admin.',
], function () {
    Route::group([
        'middleware' => [
            'can:' . AclSetupData::PERMISSION_VIEW_USERS,
        ],
    ], function () {
        Route::pattern('role', '^(?!new$).*');

        Route::get('users', AdminUserIndexController::class)->name('users.index');
        Route::get('users/{user}', AdminUserShowController::class)->name('users.show');

        Route::get('user-roles', AdminUserRoleIndexController::class)->name('user-roles.index');
        Route::get('user-roles/{role}', AdminUserRoleShowController::class)->name('user-roles.show');

        Route::get('user-permissions', AdminPermissionIndexController::class)->name('user-permissions.index');
        Route::get('user-permissions/{permission}', AdminPermissionShowController::class)->name('user-permissions.show');
    });
    Route::group([
        'middleware' => [
            'can:' . AclSetupData::PERMISSION_EDIT_USERS,
        ],
    ], function () {
        Route::get('users/{user}/edit', AdminUserEditController::class)->name('users.edit');
        Route::patch('users/{user}/edit', AdminUserUpdateController::class)->name('users.update');

        Route::get('user-roles/new', AdminUserRoleCreateController::class)->name('user-roles.create');
        Route::post('user-roles', AdminUserRoleStoreController::class)->name('user-roles.store');
        Route::get('user-roles/{role}/edit', AdminUserRoleEditController::class)->name('user-roles.edit');
        Route::patch('user-roles/{role}', AdminUserRoleUpdateController::class)->name('user-roles.update');
    });
    Route::group([
        'middleware' => [
            'can:' . AclSetupData::PERMISSION_EDIT_CMS_PAGES,
        ],
    ], function () {
        Route::resource('cms-pages', AdminCmsPagesController::class)
            ->whereNumber('cms_page');
        Route::resource('cms-redirects', AdminCmsRedirectsController::class);

        Route::get('cms-pages/assistant', AdminCmsAssistantIndexController::class)->name('cms-pages.assistant.index');
        Route::put('cms-pages/assistant', AdminCmsAssistantStoreController::class)->name('cms-pages.assistant.store');

        Route::resource('cms-templates', AdminCmsTemplatesController::class);
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
