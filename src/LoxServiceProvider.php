<?php

namespace BondarDe\Lox;

use BondarDe\Lox\Console\AboutCommandIntegration;
use BondarDe\Lox\Console\Commands\Acl\AclMakeSuperAdminCommand;
use BondarDe\Lox\Console\Commands\Acl\AclUpdateRolesAndPermissionsCommand;
use BondarDe\Lox\Console\Commands\Search\ScoutRefreshCommand;
use BondarDe\Lox\Constants\Environment;
use BondarDe\Lox\Contracts\View\PageConfig;
use BondarDe\Lox\Livewire\FileUpload;
use BondarDe\Lox\Livewire\LiveModelList;
use BondarDe\Lox\Livewire\ModelList\Actions as ModelListActions;
use BondarDe\Lox\Livewire\ModelList\Content as ModelListContent;
use BondarDe\Lox\Livewire\ModelList\Filter;
use BondarDe\Lox\Livewire\ModelList\FilterItemCount;
use BondarDe\Lox\Livewire\ModelList\Search;
use BondarDe\Lox\View\Components\Button;
use BondarDe\Lox\View\Components\Content;
use BondarDe\Lox\View\Components\DashboardItem;
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
use BondarDe\Lox\View\Components\ModelList;
use BondarDe\Lox\View\Components\ModelMeta;
use BondarDe\Lox\View\Components\ModelSummary;
use BondarDe\Lox\View\Components\NavItem;
use BondarDe\Lox\View\Components\Number;
use BondarDe\Lox\View\Components\Page;
use BondarDe\Lox\View\Components\RelativeTimestamp;
use BondarDe\Lox\View\Components\RenderingStats;
use BondarDe\Lox\View\Components\SearchHighlightedText;
use BondarDe\Lox\View\Components\Survey;
use BondarDe\Lox\View\Components\SurveyView;
use BondarDe\Lox\View\Components\UserMessages;
use BondarDe\Lox\View\Components\ValidationErrors;
use BondarDe\Lox\View\DefaultPageConfig;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LoxServiceProvider extends ServiceProvider
{
    const NAMESPACE = 'lox';

    const COMPONENTS = [
        'page' => Page::class,
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

        'model-list' => ModelList::class,
        'model-summary' => ModelSummary::class,
        'model-meta' => ModelMeta::class,

        'number' => Number::class,
        'file-size' => FileSize::class,

        'rendering-stats' => RenderingStats::class,
        'dashboard-item' => DashboardItem::class,
        'nav-item' => NavItem::class,
        'search-highlighted-text' => SearchHighlightedText::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->mergeConfigFrom(
            __DIR__ . '/config/lox.php', 'lox'
        );
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/components', self::NAMESPACE);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', self::NAMESPACE);
        $this->loadViewComponentsAs('', self::COMPONENTS);
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', self::NAMESPACE);
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');

        $this->configureRoutes();
        $this->configurePublishing();
        $this->configureCommands();

        $this->configureConfig();
        $this->configureLivewire();
        $this->configureAboutCommand();
    }

    private function configureRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/user.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');

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
            __DIR__ . '/config/lox.php' => config_path('lox.php'),
            __DIR__ . '/../package.json' => base_path('package.json'),
            __DIR__ . '/../tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__ . '/../vite.config.js' => base_path('vite.config.js'),
            __DIR__ . '/../postcss.config.js' => base_path('postcss.config.js'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/bondarde/lox'),
        ], 'views');
    }

    private function configureCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            AclMakeSuperAdminCommand::class,
            AclUpdateRolesAndPermissionsCommand::class,
            ScoutRefreshCommand::class,
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
}
