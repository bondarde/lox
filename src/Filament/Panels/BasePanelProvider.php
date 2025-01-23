<?php

namespace BondarDe\Lox\Filament\Panels;

use BondarDe\FilamentLocalAvatar\LocalAvatarProvider;
use Filament\Facades\Filament;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;

abstract class BasePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->font('none', provider: LocalFontProvider::class)
            ->defaultAvatarProvider(LocalAvatarProvider::class)
            ->colors([
                'primary' => Color::Indigo,
            ])
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

        $panel->userMenuItems(
            collect(Filament::getPanels())
                ->map(
                    fn (Panel $registeredPanel) => MenuItem::make()
                        ->visible(
                            fn () => Auth::user()->can('panel_' . $registeredPanel->getId()),
                        )
                        ->label(
                            Str::ucfirst($registeredPanel->getId()),
                        )
                        ->icon(
                            $registeredPanel->getIcons()[0] ?? null,
                        )
                        ->url($registeredPanel->getPath()),
                )
                ->toArray(),
        );

        if (config('lox.filament.panels.with_user_menu')) {
            $panel->userMenuItems([
                'profile' => MenuItem::make()
                    ->icon(function () {
                        /** @var Model $user */
                        $user = Auth::user();

                        return (new LocalAvatarProvider())->get($user);
                    })
                    ->url(fn () => route('filament.me.pages.profile')),
            ]);
        }

        if (config('lox.filament.panels.with_js')) {
            $panel->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => App::environment('local')
                    ? Blade::render("@vite('resources/js/app.js', '../.build/.vite')")
                    : new HtmlString('<script type="module" src="/=)/app.' . config('app.version') . '.js"></script>'),
            );
        }

        if (config('lox.filament.panels.with_css')) {
            if (App::environment('local')) {
                $panel->viteTheme('resources/scss/app.scss', '../.build/.vite');
            } else {
                $panel->theme(new HtmlString('<link rel="stylesheet" href="/=)/app.' . config('app.version') . '.css">'));
            }
        }

        return $panel;
    }
}
