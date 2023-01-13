<?php

use BondarDe\LaravelToolbox\Http\Controllers\TinyMceFilesController;
use BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin\SocialLoginCallbackController;
use BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin\SocialLoginRedirectController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

if (Features::enabled('sso')) {
    Route::group(['middleware' => ['web']], function () {
        Route::get('login/{provider}', SocialLoginRedirectController::class)->name('sso.redirect');
        Route::any('login/{provider}/callback', SocialLoginCallbackController::class)->name('sso.callback');
    });
}
Route::get('tinymce/{file}', TinyMceFilesController::class)->where('file', '.*');
