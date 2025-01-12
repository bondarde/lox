<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard as BaseDashboard;

class AdminDashboard extends BaseDashboard
{
    use HasPageShield;

    protected static ?string $slug = 'dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
}
