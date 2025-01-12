<x-admin-page
    title="CMS"
    h1="CMS"
>

    <x-lox::content class="inline-block">
        @include('lox::admin.cms._children', [
            'children' => $cmsPagesWithoutParent,
        ])
    </x-lox::content>


    <div class="flex flex-wrap gap-8">

        <x-dashboard-item
            label="Pages"
            :href="route('admin.cms.pages.index')"
            :as-integer="true"
        >
            {{ $cmsPagesCount }}
        </x-dashboard-item>

        <x-dashboard-item
            label="Templates"
            :href="route('admin.cms.templates.index')"
            :as-integer="true"
        >
            {{ $templatesCount }}
        </x-dashboard-item>

        <x-dashboard-item
            label="Redirects"
            :href="route('admin.cms.redirects.index')"
            :as-integer="true"
        >
            {{ $redirectsCount }}
        </x-dashboard-item>

    </div>

</x-admin-page>
