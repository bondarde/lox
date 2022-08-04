<?php

use BondarDe\LaravelToolbox\Http\Controllers\Local\ViteAssetsFallbackController;

Route::get('.build/.vite/assets/{file}', ViteAssetsFallbackController::class);
