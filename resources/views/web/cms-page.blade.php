<?php

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Support\CmsRenderer;

?>
<x-lox::page
    :title="$pageTitle"
    :h1="$h1"
    :breadcrumb-attr="$cmsPage"
    :meta-description="$metaDescription"
    :meta-robots="$metaRobots"
    :canonical="$canonical"
>

    {!! CmsRenderer::renderCmsPageContent($cmsPage) !!}

    @can('update', $cmsPage)
        <x-lox::button
            tag="a"
            :href="route('filament.admin.resources.cms-pages.edit', $cmsPage)"
            icon="📝"
        >
            {{ __('Edit page')}}
        </x-lox::button>
    @endcan

</x-lox::page>
