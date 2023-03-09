<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Database;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Console\TableCommand;
use Illuminate\Support\Facades\Artisan;

class AdminDatabaseStatusTableController
{
    public function __invoke(string $table): View
    {
        Artisan::call(TableCommand::class, [
            'table' => $table,
            '--json' => 1,
        ]);
        $output = Artisan::output();
        $tableStatus = json_decode($output);

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.database-status.table', compact(
            'table',
        ), [
            'size' => $tableStatus->table->size,
            'columns' => $tableStatus->columns,
            'indexes' => $tableStatus->indexes,
            'foreignKeys' => $tableStatus->foreign_keys,
        ]);
    }
}
