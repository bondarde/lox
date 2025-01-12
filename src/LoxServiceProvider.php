<?php

namespace BondarDe\Lox;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use BondarDe\FilamentRouteList\Models\LaravelRoute;
use BondarDe\Lox\Console\AboutCommandIntegration;
use BondarDe\Lox\Console\Commands\Cms\ExecuteCmsTasksCommand;
use BondarDe\Lox\Console\Commands\MigrateSsoIdentifiersCommand;
use BondarDe\Lox\Console\Commands\Search\ScoutRefreshCommand;
use BondarDe\Lox\Constants\Environment;
use BondarDe\Lox\Contracts\View\PageConfig;
use BondarDe\Lox\Http\Controllers\Web\CmsContentController;
use BondarDe\Lox\Livewire\FileUpload;
use BondarDe\Lox\Livewire\LiveModelList;
use BondarDe\Lox\Livewire\ModelList\Actions as ModelListActions;
use BondarDe\Lox\Livewire\ModelList\Content as ModelListContent;
use BondarDe\Lox\Livewire\ModelList\Filter;
use BondarDe\Lox\Livewire\ModelList\FilterItemCount;
use BondarDe\Lox\Livewire\ModelList\Search;
use BondarDe\Lox\Models\CmsAssistantTask;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsRedirect;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\Sushi\ApplicationModel;
use BondarDe\Lox\Models\Sushi\DatabaseRelation;
use BondarDe\Lox\Policies\AclPermissionPolicy;
use BondarDe\Lox\Policies\ApplicationModelPolicy;
use BondarDe\Lox\Policies\CmsAssistantTaskPolicy;
use BondarDe\Lox\Policies\CmsPagePolicy;
use BondarDe\Lox\Policies\CmsRedirectPolicy;
use BondarDe\Lox\Policies\CmsTemplatePolicy;
use BondarDe\Lox\Policies\DatabaseRelationPolicy;
use BondarDe\Lox\Policies\LaravelRoutePolicy;
use BondarDe\Lox\View\Components\Button;
use BondarDe\Lox\View\Components\Content;
use BondarDe\Lox\View\Components\FileSize;
use BondarDe\Lox\View\Components\Form\Boolean;
use BondarDe\Lox\View\Components\Form\Checkbox;
use BondarDe\Lox\View\Components\Form\FormActions;
use BondarDe\Lox\View\Components\Form\FormRow;
use BondarDe\Lox\View\Components\Form\Input;
use BondarDe\Lox\View\Components\Form\InputError;
use BondarDe\Lox\View\Components\Form\Matrix;
use BondarDe\Lox\View\Components\Form\Radio;
use BondarDe\Lox\View\Components\Form\Select;
use BondarDe\Lox\View\Components\Form\Textarea;
use BondarDe\Lox\View\Components\Form\TinyMce;
use BondarDe\Lox\View\Components\HtmlHeader;
use BondarDe\Lox\View\Components\NavItem;
use BondarDe\Lox\View\Components\Number;
use BondarDe\Lox\View\Components\Page;
use BondarDe\Lox\View\Components\PageFooter;
use BondarDe\Lox\View\Components\PageHeader;
use BondarDe\Lox\View\Components\RelativeTimestamp;
use BondarDe\Lox\View\Components\RenderingStats;
use BondarDe\Lox\View\Components\SearchHighlightedText;
use BondarDe\Lox\View\Components\Survey;
use BondarDe\Lox\View\Components\SurveyView;
use BondarDe\Lox\View\Components\UserMessages;
use BondarDe\Lox\View\Components\ValidationErrors;
use BondarDe\Lox\View\DefaultPageConfig;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

class LoxServiceProvider extends ServiceProvider
{
    public static string $namespace = 'lox';

    public static array $components = [
        'page' => Page::class,
        'html-header' => HtmlHeader::class,
        'page-header' => PageHeader::class,
        'page-footer' => PageFooter::class,

        'content' => Content::class,
        'form.form-row' => FormRow::class,
        'form.form-actions' => FormActions::class,
        'form.input' => Input::class,
        'form.textarea' => Textarea::class,
        'form.tiny-mce' => TinyMce::class,
        'form.input-error' => InputError::class,
        'form.checkbox' => Checkbox::class,
        'form.radio' => Radio::class,
        'form.boolean' => Boolean::class,
        'form.select' => Select::class,
        'form.matrix' => Matrix::class,
        'survey' => Survey::class,
        'survey-view' => SurveyView::class,
        'validation-errors' => ValidationErrors::class,
        'user-messages' => UserMessages::class,

        'button' => Button::class,

        'relative-timestamp' => RelativeTimestamp::class,

        'number' => Number::class,
        'file-size' => FileSize::class,

        'rendering-stats' => RenderingStats::class,
        'nav-item' => NavItem::class,
        'search-highlighted-text' => SearchHighlightedText::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->mergeConfigFrom(
            __DIR__ . '/../config/lox.php',
            'lox',
        );
    }

    public function boot(): void
    {
        $this->configureViews();
        $this->configureTranslations();
        $this->configureRoutes();
        $this->configurePublishing();
        $this->configureCommands();

        $this->configureConfig();
        $this->configureLivewire();
        $this->configureAboutCommand();

        $this->configureFilamentShield();
        $this->registerPolicies();
    }

    private function configureViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', self::$namespace);

        foreach (self::$components as $alias => $component) {
            Blade::component(self::$namespace . '::' . $alias, $component);
        }
    }

    private function configureTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', self::$namespace);
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang');
    }

    private function configureRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/user.php');

        if (config('lox.cms.fallback_route_enabled')) {
            Route::group([
                'middleware' => 'web',
            ], function () {
                Route::fallback(CmsContentController::class)->name('cms-fallback');
            });
        }

        if (App::environment(Environment::LOCAL)) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/local.php');
        }
    }

    private function configurePublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/scss/' => resource_path('scss/lox'),
        ], 'styles');

        $this->publishes([
            __DIR__ . '/../resources/tailwind/burger-menu' => resource_path('tailwind/burger-menu'),
            __DIR__ . '/../resources/tailwind/tailwind.config.js' => base_path('tailwind.config.js'),
        ], 'tailwind');

        $this->publishes([
            __DIR__ . '/../config/lox.php' => config_path('lox.php'),
            __DIR__ . '/../package.json' => base_path('package.json'),
            __DIR__ . '/../tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__ . '/../vite.config.js' => base_path('vite.config.js'),
            __DIR__ . '/../postcss.config.js' => base_path('postcss.config.js'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/bondarde/lox'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../database/migrations/001_create_cms_pages_table.php' => $this->getMigrationFileName('001_create_cms_pages_table.php'),
            __DIR__ . '/../database/migrations/002_create_cms_redirects_table.php' => $this->getMigrationFileName('002_create_cms_redirects_table.php'),
            __DIR__ . '/../database/migrations/003_create_cms_assistant_tasks_table.php' => $this->getMigrationFileName('003_create_cms_assistant_tasks_table.php'),
            __DIR__ . '/../database/migrations/004_create_cms_templates_table.php' => $this->getMigrationFileName('004_create_cms_templates_table.php'),
            __DIR__ . '/../database/migrations/005_create_cms_template_variables_table.php' => $this->getMigrationFileName('005_create_cms_template_variables_table.php'),
            __DIR__ . '/../database/migrations/006_create_cms_template_variable_values_table.php' => $this->getMigrationFileName('006_create_cms_template_variable_values_table.php'),
            __DIR__ . '/../database/migrations/007_add_template_id_to_cms_pages.php' => $this->getMigrationFileName('007_add_template_id_to_cms_pages.php'),
            __DIR__ . '/../database/migrations/008_create_sso_identifiers_table.php' => $this->getMigrationFileName('008_create_sso_identifiers_table.php'),
        ], 'lox-migrations');
    }

    private function configureCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            ScoutRefreshCommand::class,
            ExecuteCmsTasksCommand::class,
            MigrateSsoIdentifiersCommand::class,
        ]);
    }

    private function configureConfig(): void
    {
        $this->app->bind(PageConfig::class, DefaultPageConfig::class);
    }

    private function configureLivewire(): void
    {
        Livewire::component('file-upload', FileUpload::class);

        Livewire::component('live-model-list', LiveModelList::class);
        Livewire::component('model-list.search', Search::class);
        Livewire::component('model-list.filter', Filter::class);
        Livewire::component('model-list.content', ModelListContent::class);
        Livewire::component('model-list.filter-item-count', FilterItemCount::class);
        Livewire::component('model-list.actions', ModelListActions::class);
    }

    private function configureAboutCommand(): void
    {
        AboutCommand::add('Lox', AboutCommandIntegration::class);
    }

    /**
     * @throws BindingResolutionException
     */
    private function getMigrationFileName(string $migrationFileName)
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make([$this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR])
            ->flatMap(fn (string $path) => $filesystem->glob($path . '*_' . $migrationFileName))
            ->push($this->app->databasePath() . "/migrations/{$timestamp}_$migrationFileName")
            ->first();
    }

    private function configureFilamentShield(): void
    {
        FilamentShield::configurePermissionIdentifierUsing(
            fn (string $resource) => Str::of($resource)
                ->afterLast('Resources\\')
                ->before('Resource')
                ->replace('\\', '')
                ->kebab(),
        );
    }

    private function registerPolicies(): void
    {
        Gate::policy(Permission::class, AclPermissionPolicy::class);

        Gate::policy(LaravelRoute::class, LaravelRoutePolicy::class);
        Gate::policy(DatabaseRelation::class, DatabaseRelationPolicy::class);
        Gate::policy(ApplicationModel::class, ApplicationModelPolicy::class);

        Gate::policy(CmsPage::class, CmsPagePolicy::class);
        Gate::policy(CmsTemplate::class, CmsTemplatePolicy::class);
        Gate::policy(CmsRedirect::class, CmsRedirectPolicy::class);
        Gate::policy(CmsAssistantTask::class, CmsAssistantTaskPolicy::class);
    }
}
