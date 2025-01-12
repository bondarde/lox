<?php

namespace BondarDe\Lox\Models\Sushi;

use Illuminate\Database\Console\ShowCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Sushi\Sushi;

class DatabaseRelation extends Model
{
    use Sushi;

    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows(): array
    {
        Artisan::call(ShowCommand::class, [
            '--json' => 1,
            '--counts' => 1,
            '--views' => 1,
        ]);
        $output = Artisan::output();
        $databaseStatus = json_decode($output);

        return [
            ...collect($databaseStatus->tables)
                ->map(fn ($table) => [
                    ...(array) $table,
                    'label' => $table->table,
                    'type' => 'table',
                    'id' => 'table:' . $table->table,
                ])
                ->toArray(),
            ...collect($databaseStatus->views)
                ->map(fn ($view) => [
                    ...(array) $view,
                    'label' => $view->view,
                    'type' => 'view',
                    'id' => 'view:' . $view->view,
                ])
                ->toArray(),
        ];
    }
}
