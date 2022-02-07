<?php

namespace BondarDe\LaravelToolbox\Http\Controllers;

use Illuminate\Support\Facades\File;

class TinyMceFilesController
{
    public function __invoke(string $filename)
    {
        $absoluteFilename = base_path('vendor/tinymce/tinymce/' . $filename);

        if (!File::exists($absoluteFilename)) {
            abort(404);
        }

        $headers = [
            'Content-Type' => self::mimeType($absoluteFilename),
        ];

        return response()->file($absoluteFilename, $headers);
    }

    private static function mimeType(string $absoluteFilename): string
    {
        $typeByExtension = [
            'js' => 'text/javascript;charset=UTF-8',
            'css' => 'text/css;charset=UTF-8',
        ];

        $extension = File::extension(strtolower($absoluteFilename));

        if (!isset($typeByExtension[$extension])) {
            return File::mimeType($absoluteFilename);
        }

        return $typeByExtension[$extension];
    }
}
