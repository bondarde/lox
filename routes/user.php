<?php

use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\DeleteAccountConfirmationController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\DeleteAccountDeleteController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\LogoutOtherBrowserSessionsController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\SecondFactorEnableConfirmController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\SecondFactorEnableStartController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserPasswordEditController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserPasswordUpdateController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserProfileEditController;
use BondarDe\LaravelToolbox\Http\Controllers\User\Profile\UserProfileUpdateController;
use BondarDe\LaravelToolbox\Http\Controllers\User\TwoFactorRecoveryController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


Route::group([
    'middleware' => config('fortify.middleware', ['web']),
], function () {
    if (Features::enabled(Features::twoFactorAuthentication())) {
        Route::get('/two-factor-recovery', TwoFactorRecoveryController::class)->name('two-factor.recovery')
            ->middleware([
                'guest:' . config('fortify.guard'),
            ]);
    }
});

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

    Route::get('/user/profile/enable-second-factor', SecondFactorEnableStartController::class)->name('user.profile.second-factor.enable.start')
        ->middleware([
            'password.confirm',
        ]);
    Route::post('/user/profile/enable-second-factor', SecondFactorEnableConfirmController::class)->name('user.profile.second-factor.enable.confirm')
        ->middleware([
            'password.confirm',
        ]);

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
