<?php

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Support\CmsRenderer;

?>
<x-page
    :title="$pageTitle"
    :h1="$h1"
    :breadcrumb-attr="$cmsPage"
    :meta-description="$metaDescription"
    :meta-robots="$metaRobots"
    :canonical="$canonical"
>

    {!! CmsRenderer::renderCmsPageContent($cmsPage) !!}

    @can('update', $cmsPage)
        <x-button
            tag="a"
            :href="route('admin.cms.pages.edit', $cmsPage)"
            icon="📝"
        >
            {{ __('Edit page')}}
        </x-button>
    @endcan

</x-page>
