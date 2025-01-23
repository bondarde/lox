<?php

namespace BondarDe\Lox\Filament\Panels;

use BondarDe\FilamentLocalAvatar\LocalAvatarProvider;
use Filament\FontProviders\LocalFontProvider;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

abstract class BasePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->font('none', provider: LocalFontProvider::class)
            ->defaultAvatarProvider(LocalAvatarProvider::class)
            ->colors([
                'primary' => Color::Indigo,
            ]);

        if (config('lox.filament.panels.with_user_menu')) {
            $panel->userMenuItems([
                'profile' => MenuItem::make()
                    ->icon(function () {
                        /** @var Model $user */
                        $user = Auth::user();

                        return (new LocalAvatarProvider())->get($user);
                    })
                    ->url(fn () => route('filament.me.pages.profile')),
                'logout' => MenuItem::make()
                    ->label(__('Logout')),
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
