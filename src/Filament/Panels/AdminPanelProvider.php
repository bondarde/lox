<?php

namespace BondarDe\Lox\Filament\Panels;

use App\Models\User;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BondarDe\FilamentRouteList\FilamentRouteListPlugin;
use Exception;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class AdminPanelProvider extends BasePanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        parent::panel($panel)
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/scss/app.scss', '../.build/.vite')
            ->discoverPages(in: __DIR__ . '/../AdminPanel/Pages', for: 'BondarDe\\Lox\\Filament\\AdminPanel\\Pages')
            ->discoverResources(in: __DIR__ . '/../AdminPanel/Resources', for: 'BondarDe\\Lox\\Filament\\AdminPanel\\Resources')
            ->discoverResources(in: app_path('Filament/AdminPanel/Resources'), for: 'App\\Filament\\AdminPanel\\Resources')
            ->pages([
            ])
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
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->favicon('/img/favicons/favicon-192x192.png');

        return $panel;
    }
}
