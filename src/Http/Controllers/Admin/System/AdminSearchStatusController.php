<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\SearchIndexStatus;
use ReflectionMethod;
use TeamTNT\Scout\Console\StatusCommand;
use TeamTNT\TNTSearch\Exceptions\IndexNotFoundException;

class AdminSearchStatusController
{
    public function __invoke()
    {
        $statusRows = self::status();

        return view('lox::admin.system.search-status', compact(
            'statusRows',
        ));
    }

    private static function status()
    {
        $rows = [];
        $cmd = new StatusCommand();

        $reflectionMethod = new ReflectionMethod($cmd, 'getSearchableModelsFromClasses');
        $reflectionMethod->setAccessible(true);

        $loadTNTEngine = new ReflectionMethod($cmd, 'loadTNTEngine');
        $loadTNTEngine->setAccessible(true);

        $searchableModels = $reflectionMethod->invoke($cmd);

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
        string           $className,
        ReflectionMethod $loadTNTEngine,
        StatusCommand    $cmd,
    ): SearchIndexStatus
    {
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
        $recordsDifference = $rowsTotal - $rowsIndexed;

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
