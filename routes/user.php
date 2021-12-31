<?php

use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\DeleteAccountConfirmationController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\DeleteAccountDeleteController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\LogoutOtherBrowserSessionsController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserPasswordEditController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserPasswordUpdateController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserProfileEditController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserProfileUpdateController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'web',
        'auth:sanctum',
        'verified',
    ],
], function () {
    Route::get('/user/profile/profile-information', UserProfileEditController::class)->name('user.profile.profile-information.edit');
    Route::post('/user/profile/profile-information', UserProfileUpdateController::class)->name('user.profile.profile-information.update');

    Route::get('/user/profile/update-password', UserPasswordEditController::class)->name('user.profile.password.edit');
    Route::post('/user/profile/update-password', UserPasswordUpdateController::class)->name('user.profile.password.update');

    Route::post('/user/profile/logout-other-browser-sessions', LogoutOtherBrowserSessionsController::class)->name('user.profile.logout-other-browser-sessions')
        ->middleware([
            'password.confirm',
        ]);

    Route::get('/user/profile/delete-account', DeleteAccountConfirmationController::class)->name('user.profile.delete-account.confirm')->middleware([
        'password.confirm',
        'throttle:12,1',
    ]);
    Route::post('/user/profile/delete-account', DeleteAccountDeleteController::class)->name('user.profile.delete-account.delete')
        ->middleware([
            'password.confirm',
        ]);
});
