<?php

use BondarDe\LaravelToolbox\Http\Controllers\TinyMceFilesController;

Route::get('tinymce/{file}', TinyMceFilesController::class)->where('file', '.*');
