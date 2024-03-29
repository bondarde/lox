<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Database;

use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Console\ShowCommand;
use Illuminate\Support\Facades\Artisan;

class AdminDatabaseStatusIndexController
{
    public function __invoke(): View
    {
        Artisan::call(ShowCommand::class, [
            '--json' => 1,
            '--counts' => 1,
            '--views' => 1,
        ]);
        $output = Artisan::output();
        $databaseStatus = json_decode($output);
        $tableSizeSum = collect($databaseStatus->tables)->sum('size');
        $views = $databaseStatus->views;

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.database.index', compact(
            'databaseStatus',
            'tableSizeSum',
            'views',
        ));
    }
}
