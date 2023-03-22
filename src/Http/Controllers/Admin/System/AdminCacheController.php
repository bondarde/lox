<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System;

use BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data\CacheItem;
use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class AdminCacheController
{
    public function __invoke()
    {
        $storage = Cache::getStore(); // will return instance of FileStore
        $filesystem = $storage->getFilesystem(); // will return instance of Filesystem
        $cacheDir = Cache::getDirectory();
        $values = [];

        foreach ($filesystem->allFiles($cacheDir) as $dir) {
            $cachePath = $dir->getPath();

            if (!is_dir($cachePath)) {
                continue;
            }

            foreach ($filesystem->allFiles($cachePath) as $file) {
                /** @var SplFileInfo $file */
                $content = File::get($file->getRealpath());
                $expires = substr($content, 0, 10);
                $filename = $file->getFilename();
                $values[$filename] = new CacheItem(
                    filename: $filename,
                    filepath: $file->getRealPath(),
                    raw: $content,
                    value: unserialize(substr($content, 10)),
                    expiresAt: Carbon::createFromTimestamp($expires),
                );
            }
        }

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.cache', compact(
            'values',
        ));
    }
}
