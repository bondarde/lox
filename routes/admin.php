<?php

use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserEditController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserIndexController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserShowController;
use BondarDe\LaravelToolbox\Http\Controllers\Admin\Users\AdminUserUpdateController;

Route::group([
    'middleware' => [
        'web',
        'auth:sanctum',
        'verified',
        'groups:admin',
    ],
    'prefix' => 'admin/',
    'as' => 'admin.',
], function () {
    Route::get('users', AdminUserIndexController::class)->name('users.index');
    Route::get('users/{user}', AdminUserShowController::class)->name('users.show');
    Route::get('users/{user}/edit', AdminUserEditController::class)->name('users.edit');
    Route::post('users/{user}/edit', AdminUserUpdateController::class)->name('users.update');
});
