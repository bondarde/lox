<ul {{ $attributes->merge([
    'class' => 'flex flex-wrap gap-4',
]) }}>

    <x-nav-item
        :href="route('admin.cms.overview')"
        active-route="admin.cms.*"
    >
        Overview
    </x-nav-item>

    <x-nav-item
        :href="route('admin.cms-pages.index')"
        active-route="admin.cms-pages.*"
    >
        Pages
    </x-nav-item>

    <x-nav-item
        :href="route('admin.cms-redirects.index')"
        active-route="admin.cms-redirects.*"
    >
        Redirects
    </x-nav-item>

    <x-nav-item
        :href="route('admin.cms-templates.index')"
        active-route="admin.cms-templates.*"
    >
        Templates
    </x-nav-item>

    <x-nav-item
        :href="route('admin.cms-pages.assistant.index')"
        active-route="admin.cms-pages.assistant.*"
    >
        Assistent
    </x-nav-item>
</ul>
