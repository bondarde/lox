<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use Filament\Pages\Page;

class PhpInfo extends Page
{
    protected ?string $heading = 'PHP Info';
    protected ?string $subheading = 'Information about PHP’s configuration';

    protected static string $view = 'lox::admin.system.php-info';

    protected static ?string $navigationLabel = 'PHP Info';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 900;

    public string $phpInfoContents;

    public function mount(): void
    {
        ob_start();
        phpinfo();
        $this->phpInfoContents = ob_get_clean();
    }
}
