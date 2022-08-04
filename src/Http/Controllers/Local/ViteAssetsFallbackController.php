<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Local;

use Illuminate\Support\Facades\File;

class ViteAssetsFallbackController
{
    public function __invoke(string $file)
    {
        $path = base_path('.build/.vite/assets/' . $file);

        $mime = match (File::extension($path)) {
            'css' => 'text/css',
            'js' => 'application/javascript',
            default => abort(404),
        };

        return response(File::get($path), 200, [
            'Content-Type' => $mime,
        ]);
    }
}
