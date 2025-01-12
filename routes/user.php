<?php

use BondarDe\Lox\Http\Controllers\User\Profile\DeleteAccountConfirmationController;
use BondarDe\Lox\Http\Controllers\User\Profile\DeleteAccountDeleteController;
use BondarDe\Lox\Http\Controllers\User\Profile\LogoutOtherBrowserSessionsController;
use BondarDe\Lox\Http\Controllers\User\Profile\RecoveryCodesResetConfirmController;
use BondarDe\Lox\Http\Controllers\User\Profile\RecoveryCodesResetStartController;
use BondarDe\Lox\Http\Controllers\User\Profile\SecondFactorDisableConfirmController;
use BondarDe\Lox\Http\Controllers\User\Profile\SecondFactorDisableStartController;
use BondarDe\Lox\Http\Controllers\User\Profile\SecondFactorEnableConfirmController;
use BondarDe\Lox\Http\Controllers\User\Profile\SecondFactorEnableStartController;
use BondarDe\Lox\Http\Controllers\User\Profile\UserPasswordEditController;
use BondarDe\Lox\Http\Controllers\User\Profile\UserPasswordUpdateController;
use BondarDe\Lox\Http\Controllers\User\Profile\UserProfileEditController;
use BondarDe\Lox\Http\Controllers\User\Profile\UserProfileIndexController;
use BondarDe\Lox\Http\Controllers\User\Profile\UserProfileUpdateController;
use BondarDe\Lox\Http\Controllers\User\TwoFactorRecoveryController;
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
        'auth:web',
        'verified',
    ],
], function () {
    Route::get('/user', UserProfileIndexController::class)->name('user.index');

    Route::get('/user/profile/profile-information', UserProfileEditController::class)->name('user.profile.profile-information.edit');
    Route::post('/user/profile/profile-information', UserProfileUpdateController::class)->name('user.profile.profile-information.update');

    Route::get('/user/profile/update-password', UserPasswordEditController::class)->name('user.profile.password.edit');
    Route::post('/user/profile/update-password', UserPasswordUpdateController::class)->name('user.profile.password.update');

    Route::group([
        'middleware' => [
            'password.confirm',
        ],
    ], function () {
        Route::get('/user/profile/enable-second-factor', SecondFactorEnableStartController::class)->name('user.profile.second-factor.enable.start');
        Route::post('/user/profile/enable-second-factor', SecondFactorEnableConfirmController::class)->name('user.profile.second-factor.enable.confirm');

        Route::get('/user/profile/disable-second-factor', SecondFactorDisableStartController::class)->name('user.profile.second-factor.disable.start');
        Route::post('/user/profile/disable-second-factor', SecondFactorDisableConfirmController::class)->name('user.profile.second-factor.disable.confirm');

        Route::get('/user/profile/reset-recovery-codes', RecoveryCodesResetStartController::class)->name('user.profile.reset-recovery-codes.start');
        Route::post('/user/profile/reset-recovery-codes', RecoveryCodesResetConfirmController::class)->name('user.profile.reset-recovery-codes.confirm');

        Route::post('/user/profile/logout-other-browser-sessions', LogoutOtherBrowserSessionsController::class)->name('user.profile.logout-other-browser-sessions');

        Route::get('/user/profile/delete-account', DeleteAccountConfirmationController::class)->name('user.profile.delete-account.confirm')
            ->middleware([
                'throttle:12,1',
            ]);
        Route::post('/user/profile/delete-account', DeleteAccountDeleteController::class)->name('user.profile.delete-account.delete');
    });
});
