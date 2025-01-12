<?php

namespace BondarDe\Lox\Filament\UserPanel\Pages;

use Filament\Pages\Dashboard;

class Me extends Dashboard
{
    protected static ?string $slug = 'profile';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'My Profile';

    protected static string $view = 'lox::filament.user.pages.me';

    public function getTitle(): string
    {
        return __('My Profile');
    }

    public static function getNavigationLabel(): string
    {
        return __('My Profile');
    }

    public function getSubheading(): string
    {
        return __('Profile Information');
    }
}
