<?php

namespace BondarDe\Lox\Filament\UserPanel\Pages;

use Filament\Pages\Dashboard;
use Filament\Pages\Page;

class Me extends Dashboard
{
    protected static ?string $slug = 'profile';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'My Profile';
    protected static ?string $title = 'My Profile';
}
