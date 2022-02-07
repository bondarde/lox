<?php

namespace BondarDe\LaravelToolbox\Http\Controllers;

use File;

class TinyMceFilesController
{
    public function __invoke(string $filename)
    {
        $absoluteFilename = base_path('vendor/tinymce/tinymce/' . $filename);

        if (!File::exists($absoluteFilename)) {
            abort(404);
        }

        readfile($absoluteFilename);

        response(['Content-Type' => File::type($absoluteFilename)]);
    }
}
