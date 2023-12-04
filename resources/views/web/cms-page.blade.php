<x-page
    :title="$pageTitle"
    :h1="$h1"
    :breadcrumb-attr="$cmsPage"
    :meta-description="$metaDescription"
    :meta-robots="$metaRobots"
    :canonical="$canonical"
>

    <x-content class="prose">
        {!! $content !!}
    </x-content>

    @can('update', $cmsPage)
        <x-button
            tag="a"
            :href="route('admin.cms-pages.edit', $cmsPage)"
            icon="📝"
        >
            {{ __('Edit page')}}
        </x-button>
    @endcan

</x-page>
