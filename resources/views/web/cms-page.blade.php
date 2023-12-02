<x-page
    :title="$pageTitle"
    :h1="$h1"
    :breadcrumb-attr="$cmsPage"
    :meta-description="$metaDescription"
>

    <x-content class="prose">
        {!! $content !!}
    </x-content>

</x-page>
