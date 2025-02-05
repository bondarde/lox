<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use BondarDe\Lox\Http\Controllers\Admin\System\Data\CacheItem;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Cache\DatabaseStore;
use Illuminate\Cache\FileStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Cache extends Page
{
    use HasPageShield;

    protected ?string $heading = 'Cache';
    protected ?string $subheading = 'Cached values';

    protected static string $view = 'lox::admin.system.cache';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Application Data';
    protected static ?string $navigationLabel = 'Cache';
    protected static ?int $navigationSort = 900;

    public object|array $systemStatus;

    public function getViewData(): array
    {
        $storage = \Illuminate\Support\Facades\Cache::getStore();
        $storageType = get_class($storage);

        $values = match ($storageType) {
            DatabaseStore::class => self::databaseStoreValues(),
            FileStore::class => self::fileStoreValues($storage),
        };

        return compact('values');
    }

    private static function databaseStoreValues(): array
    {
        $table = config('cache.stores.database.table');

        return DB::table($table)
            ->get()
            ->map(fn (object $item) => new CacheItem(
                filename: $item->key,
                filepath: '-',
                raw: $item->value,
                value: unserialize($item->value),
                expiresAt: Carbon::createFromTimestamp($item->expiration),
            ))
            ->toArray();
    }

    private static function fileStoreValues(FileStore $storage): array
    {
        $filesystem = $storage->getFilesystem();
        $cacheDir = \Illuminate\Support\Facades\Cache::getDirectory();
        $values = [];

        foreach ($filesystem->allFiles($cacheDir) as $dir) {
            $cachePath = $dir->getPath();

            if (! is_dir($cachePath)) {
                continue;
            }

            foreach ($filesystem->allFiles($cachePath) as $file) {
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

        return $values;
    }
}
