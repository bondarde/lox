<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use Filament\Pages\Page;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class About extends Page
{
    protected ?string $heading = 'About';
    protected ?string $subheading = 'System information';

    protected static string $view = 'lox::admin.system.about';

    protected static ?string $navigationLabel = 'About';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 900;

    public object|array $systemStatus;

    public function mount(): void
    {
        try {
            Artisan::call(AboutCommand::class, [
                '--json' => 1,
            ]);
            $output = Artisan::output();
            $this->systemStatus = json_decode($output);
        } catch (Throwable $e) {
            $this->systemStatus = [
                'ERROR' => [
                    'Exception' => $e::class,
                    'message' => $e->getMessage(),
                ],
            ];
        }
    }
}
