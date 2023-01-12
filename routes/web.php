<?php

use BondarDe\LaravelToolbox\Http\Controllers\TinyMceFilesController;
use BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin\SocialLoginCallbackController;
use BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin\SocialLoginRedirectController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

if (Features::enabled('social-login')) {
    Route::group(['middleware' => ['web']], function () {
        Route::get('login/{socialLoginProvider}', SocialLoginRedirectController::class)->name('social-login.redirect');
        Route::any('login/{socialLoginProvider}/callback', SocialLoginCallbackController::class)->name('social-login.callback');
    });
}
Route::get('tinymce/{file}', TinyMceFilesController::class)->where('file', '.*');
