<?php

use BondarDe\LaravelToolbox\Http\Controllers\TinyMceFilesController;
use BondarDe\LaravelToolbox\Http\Controllers\Web\Sso\SsoCallbackController;
use BondarDe\LaravelToolbox\Http\Controllers\Web\Sso\SsoRedirectController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

if (Features::enabled('sso')) {
    Route::group(['middleware' => ['web']], function () {
        Route::get('login/{provider}', SsoRedirectController::class)->name('sso.redirect');
        Route::any('login/{provider}/callback', SsoCallbackController::class)->name('sso.callback');
    });
}
Route::get('tinymce/{file}', TinyMceFilesController::class)->where('file', '.*');
