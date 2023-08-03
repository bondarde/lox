<?php

namespace BondarDe\Lox\Http\Controllers\Local;

use Illuminate\Support\Facades\File;

class ViteAssetsFallbackController
{
    public function __invoke(string $file)
    {
        $path = base_path('.build/.vite/assets/' . $file);

        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $mime = match (File::extension($path)) {
            'css' => 'text/css',
            'js' => 'application/javascript',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'eot' => 'application/vnd.ms-fontobject',
            'ttf' => 'font/ttf',
            'svg' => 'image/svg+xml',
            default => abort(404),
        };

        return response(File::get($path), 200, [
            'Content-Type' => $mime,
        ]);
    }
}
