<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\SearchIndexStatus;
use BondarDe\Lox\Support\Search\DiscoveryUtil;
use Filament\Pages\Page;
use ReflectionMethod;
use TeamTNT\Scout\Console\StatusCommand;
use TeamTNT\TNTSearch\Exceptions\IndexNotFoundException;

class SearchStatus extends Page
{
    protected ?string $heading = 'Search Status';
    protected ?string $subheading = 'Scout TNT Search status';

    protected static string $view = 'lox::admin.system.search-status';

    protected static ?string $navigationLabel = 'Search Status';

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 900;

    protected function getViewData(): array
    {
        $statusRows = self::status();

        return compact('statusRows');
    }

    private static function status(): array
    {
        $rows = [];
        $cmd = new StatusCommand();

        $loadTNTEngine = new ReflectionMethod($cmd, 'loadTNTEngine');
        $loadTNTEngine->setAccessible(true);

        $searchableModels = DiscoveryUtil::getModels();

        foreach ($searchableModels as $className) {
            $rows[] = self::toSearchIndexStatus(
                $className,
                $loadTNTEngine,
                $cmd,
            );
        }

        return $rows;
    }

    protected static function toSearchIndexStatus(
        string $className,
        ReflectionMethod $loadTNTEngine,
        StatusCommand $cmd,
    ): SearchIndexStatus {
        $model = new $className();

        $tnt = $loadTNTEngine->invoke($cmd, $model);
        $indexName = $model->searchableAs() . '.index';

        try {
            $tnt->selectIndex($indexName);
            $rowsIndexed = $tnt->totalDocumentsInCollection();
        } catch (IndexNotFoundException) {
            $rowsIndexed = 0;
        }

        $rowsTotal = $model->count();
        $recordsDifference = abs($rowsTotal - $rowsIndexed);

        $indexedColumns = $rowsTotal
            ? array_keys($model->first()->toSearchableArray())
            : [];

        return new SearchIndexStatus(
            className: $className,
            indexName: $indexName,
            indexColumns: $indexedColumns,
            dbRowsCount: $rowsTotal,
            indexedRowsCount: $rowsIndexed,
            delta: $recordsDifference,
        );
    }
}
