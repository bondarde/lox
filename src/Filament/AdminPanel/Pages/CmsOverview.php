<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use BondarDe\Lox\Repositories\CmsAssistantTaskRepository;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsRedirectRepository;
use BondarDe\Lox\Repositories\CmsTemplateRepository;
use Filament\Pages\Page;

class CmsOverview extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?int $navigationSort = 10;

    protected static string $view = 'lox::admin.cms.overview';

    public static function getNavigationGroup(): ?string
    {
        return __('lox::lox.admin.cms.navigation_group_name');
    }

    public static function getSlug(): string
    {
        return __('lox::lox.admin.cms.overview.slug');
    }

    public static function getNavigationLabel(): string
    {
        return __('lox::lox.admin.cms.overview.navigation_label');
    }

    public function getTitle(): string
    {
        return __('lox::lox.admin.cms.overview.navigation_label');
    }

    protected function getViewData(): array
    {
        /** @var CmsPageRepository $cmsPageRepository */
        /** @var CmsTemplateRepository $cmsTemplateRepository */
        /** @var CmsRedirectRepository $cmsRedirectRepository */
        $cmsPageRepository = app(CmsPageRepository::class);
        $cmsTemplateRepository = app(CmsTemplateRepository::class);
        $cmsRedirectRepository = app(CmsRedirectRepository::class);
        $cmsAssistantTaskRepository = app(CmsAssistantTaskRepository::class);

        $cmsPagesWithoutParent = $cmsPageRepository->withoutParents();
        $cmsPagesCount = $cmsPageRepository->count();
        $templatesCount = $cmsTemplateRepository->count();
        $redirectsCount = $cmsRedirectRepository->count();
        $assistantTasksCount = $cmsAssistantTaskRepository->count();

        return compact(
            'cmsPagesWithoutParent',
            'cmsPagesCount',
            'templatesCount',
            'redirectsCount',
            'assistantTasksCount',
        );
    }
}
