<?php

namespace BondarDe\Lox\Filament\Panels;

use Exception;
use Filament\Panel;

class UserPanelProvider extends BasePanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel)
            ->id('me')
            ->path('me')
            ->discoverPages(in: __DIR__ . '/../UserPanel/Pages', for: 'BondarDe\\Lox\\Filament\\UserPanel\\Pages')
            ->discoverPages(in: app_path('Filament/UserPanel/Pages'), for: 'App\\Filament\\UserPanel\\Pages')
            ->discoverWidgets(in: app_path('Filament/AdminPanel/Widgets'), for: 'App\\Filament\\AdminPanel\\Widgets')
            ->discoverResources(in: __DIR__ . '/../UserPanel/Resources', for: 'BondarDe\\Lox\\Filament\\UserPanel\\Resources')
            ->discoverResources(in: app_path('Filament/UserPanel/Resources'), for: 'App\\Filament\\UserPanel\\Resources');
    }
}
