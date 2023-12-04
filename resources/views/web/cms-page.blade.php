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

</x-page>
