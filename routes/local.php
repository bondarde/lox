<?php

use BondarDe\LaravelToolbox\Http\Controllers\Local\ViteAssetsFallbackController;
use Illuminate\Support\Facades\Route;

Route::get('.build/.vite/assets/{file}', ViteAssetsFallbackController::class)->where('file', '.*');
