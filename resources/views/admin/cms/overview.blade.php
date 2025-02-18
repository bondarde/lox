<?php

use BondarDe\Lox\Models\CmsAssistantTask;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsRedirect;
use BondarDe\Lox\Models\CmsTemplate;

?>
<x-filament-panels::page>

    <div class="flex flex-wrap gap-4 text-sm">
        @can('view-any', CmsPage::class)
            <a href="{{ route('filament.admin.resources.cms-pages.index') }}">
                <x-filament::section compact>
                    <div class="text-2xl font-semibold">
                        {{ $cmsPagesCount }}
                    </div>
                    {{ $cmsPagesCount === 1 ? __('lox::lox.admin.cms.pages.label') : __('lox::lox.admin.cms.pages.plural_label') }}
                </x-filament::section>
            </a>
        @endcan
        @can('view-any', CmsTemplate::class)
            <a href="{{ route('filament.admin.resources.cms-templates.index') }}">
                <x-filament::section compact>
                    <div class="text-2xl font-semibold">
                        {{ $templatesCount }}
                    </div>
                    {{ $templatesCount === 1 ? __('lox::lox.admin.cms.templates.label') : __('lox::lox.admin.cms.templates.plural_label') }}
                </x-filament::section>
            </a>
        @endcan
        @can('view-any', CmsRedirect::class)
            <a href="{{ route('filament.admin.resources.cms-redirects.index') }}">
                <x-filament::section compact>
                    <div class="text-2xl font-semibold">
                        {{ $redirectsCount }}
                    </div>
                    {{ $redirectsCount === 1 ? __('lox::lox.admin.cms.redirects.label') : __('lox::lox.admin.cms.redirects.plural_label') }}
                </x-filament::section>
            </a>
        @endcan
        @can('view-any', CmsAssistantTask::class)
            <a href="{{ route('filament.admin.resources.cms-tasks.index') }}">
                <x-filament::section compact>
                    <div class="text-2xl font-semibold">
                        {{ $assistantTasksCount }}
                    </div>
                    {{ $assistantTasksCount === 1 ? __('lox::lox.admin.cms.tasks.label') : __('lox::lox.admin.cms.tasks.plural_label') }}
                </x-filament::section>
            </a>
        @endcan
    </div>

    <x-filament::section
        :heading="__('lox::lox.admin.cms.pages.plural_label')"
    >
        @include('lox::admin.cms._children', [
            'children' => $cmsPagesWithoutParent,
        ])
    </x-filament::section>

</x-filament-panels::page>
