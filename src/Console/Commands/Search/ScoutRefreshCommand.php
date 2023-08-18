<?php

namespace BondarDe\Lox\Console\Commands\Search;

use BondarDe\Lox\Support\Search\DiscoveryUtil;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Laravel\Scout\Console\FlushCommand;
use Laravel\Scout\Console\ImportCommand;

class ScoutRefreshCommand extends Command
{
    protected $signature = 'scout:refresh {model?}';
    protected $description = 'Refreshes Scout search indexes';

    public function handle(): void
    {
        $searchModels = $this->argument('model')
            ? [$this->argument('model')]
            : DiscoveryUtil::getModels();

        foreach ($searchModels as $model) {
            Artisan::call(FlushCommand::class, [
                'model' => $model,
            ], $this->getOutput());
            Artisan::call(ImportCommand::class, [
                'model' => $model,
            ], $this->getOutput());
        }
    }
}
