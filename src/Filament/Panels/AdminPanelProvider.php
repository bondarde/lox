<?php

namespace BondarDe\Lox\Filament\Panels;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BondarDe\FilamentRouteList\FilamentRouteListPlugin;
use BondarDe\Lox\Filament\AdminPanel\Resources\ApplicationModel\ApplicationModelResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTask\CmsAssistantTaskResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage\CmsPageResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirect\CmsRedirectResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\CmsTemplateResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\DatabaseRelation\DatabaseRelationResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\Permission\PermissionResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\User\UserResource;
use Exception;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Support\Str;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class AdminPanelProvider extends BasePanelProvider
{
    private static array $resourcesByConfigPermission = [
        'permission' => PermissionResource::class,
        'user' => UserResource::class,

        'application_model' => ApplicationModelResource::class,
        'database_relation' => DatabaseRelationResource::class,

        'cms_assistant_task' => CmsAssistantTaskResource::class,
        'cms_page' => CmsPageResource::class,
        'cms_redirect' => CmsRedirectResource::class,
        'cms_template' => CmsTemplateResource::class,
    ];

    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel)
            ->default()
            ->id('admin')
            ->path('admin')
            ->icons([
                'heroicon-o-cog-6-tooth',
            ])
            ->discoverPages(in: __DIR__ . '/../AdminPanel/Pages', for: 'BondarDe\\Lox\\Filament\\AdminPanel\\Pages')
            ->discoverPages(in: app_path('Filament/AdminPanel/Pages'), for: 'App\\Filament\\AdminPanel\\Pages')
            ->discoverWidgets(in: app_path('Filament/AdminPanel/Widgets'), for: 'App\\Filament\\AdminPanel\\Widgets')
            ->discoverResources(in: app_path('Filament/AdminPanel/Resources'), for: 'App\\Filament\\AdminPanel\\Resources')
            ->plugin(
                FilamentLaravelLogPlugin::make()
                    ->navigationSort(100)
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

        $config = config('lox.filament.panels.admin.load_resources');
        foreach (self::$resourcesByConfigPermission as $configName => $resourceClass) {
            $isEnabled = $config[$configName] ?? false;

            if (! $isEnabled) {
                continue;
            }

            $namespace = Str::of($resourceClass)
                ->beforeLast('\\')
                ->toString();
            $subPath = Str::of($namespace)
                ->after('AdminPanel\\Resources')
                ->replace('\\', '/')
                ->toString();

            $path = __DIR__ . '/../AdminPanel/Resources' . $subPath;
            $panel->discoverResources(in: $path, for: $namespace);
        }

        return $panel;
    }

    protected function getNavigationGroups(): array
    {
        return [
            'CMS',
            __('filament-shield::filament-shield.nav.group'),
            'System',
            'Application Data',
        ];
    }
}
