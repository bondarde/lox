<?php

namespace BondarDe\Lox\Filament\Panels;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BondarDe\FilamentRouteList\FilamentRouteListPlugin;
use Exception;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class AdminPanelProvider extends BasePanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel)
            ->default()
            ->id('admin')
            ->path('admin')
            ->icons([
                'heroicon-o-cog-6-tooth',
            ])
            ->discoverPages(in: __DIR__ . '/../AdminPanel/Pages', for: 'BondarDe\\Lox\\Filament\\AdminPanel\\Pages')
            ->discoverPages(in: app_path('Filament/AdminPanel/Pages'), for: 'App\\Filament\\AdminPanel\\Pages')
            ->discoverResources(in: __DIR__ . '/../AdminPanel/Resources', for: 'BondarDe\\Lox\\Filament\\AdminPanel\\Resources')
            ->discoverResources(in: app_path('Filament/AdminPanel/Resources'), for: 'App\\Filament\\AdminPanel\\Resources')
            ->plugin(
                FilamentLaravelLogPlugin::make()
                    ->authorize(fn () => Filament::auth()->user()->can('page_ViewLog')),
            )
            ->plugin(
                FilamentRouteListPlugin::make(),
            )
            ->plugin(
                FilamentShieldPlugin::make(),
            )
            ->plugin(
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(config('lox.filament.locales')),
            );
    }
}
