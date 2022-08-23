<?php

use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserPermissions\AdminPermissionIndexController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserPermissions\AdminPermissionShowController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles\AdminUserRoleCreateController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles\AdminUserRoleEditController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles\AdminUserRoleIndexController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles\AdminUserRoleShowController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles\AdminUserRoleStoreController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\UserRoles\AdminUserRoleUpdateController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserEditController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserIndexController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserShowController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserUpdateController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'web',
        'auth:sanctum',
        'verified',
        'role:super-admin',
    ],
    'prefix' => 'admin/',
    'as' => 'admin.',
], function () {
    Route::get('users', AdminUserIndexController::class)->name('users.index');
    Route::get('users/{user}', AdminUserShowController::class)->name('users.show');
    Route::get('users/{user}/edit', AdminUserEditController::class)->name('users.edit');
    Route::patch('users/{user}/edit', AdminUserUpdateController::class)->name('users.update');

    Route::get('user-roles', AdminUserRoleIndexController::class)->name('user-roles.index');
    Route::get('user-roles/new', AdminUserRoleCreateController::class)->name('user-roles.create');
    Route::post('user-roles', AdminUserRoleStoreController::class)->name('user-roles.store');
    Route::get('user-roles/{role}', AdminUserRoleShowController::class)->name('user-roles.show');
    Route::get('user-roles/{role}/edit', AdminUserRoleEditController::class)->name('user-roles.edit');
    Route::patch('user-roles/{role}', AdminUserRoleUpdateController::class)->name('user-roles.update');

    Route::get('user-permissions', AdminPermissionIndexController::class)->name('user-permissions.index');
    Route::get('user-permissions/{permission}', AdminPermissionShowController::class)->name('user-permissions.show');
});
