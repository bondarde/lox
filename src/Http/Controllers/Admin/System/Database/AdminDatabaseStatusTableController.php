<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Database;

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

        if (!$tableStatus) {
            abort(404);
        }

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.database.table', compact(
            'table',
        ), [
            'size' => $tableStatus->table->size,
            'columns' => $tableStatus->columns,
            'indexes' => $tableStatus->indexes,
            'foreignKeys' => $tableStatus->foreign_keys,
        ]);
    }
}
