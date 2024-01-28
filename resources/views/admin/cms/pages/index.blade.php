<x-admin-page
    :title="__('CMS Pages')"
>

    <x-slot:header>
        <div class="flex flex-wrap gap-4">
            <h1 class="grow">
                {{ __('CMS Pages') }}
            </h1>
            <div>
                <x-button
                    color="green"
                    tag="a"
                    :href="route('admin.cms-pages.create')"
                    icon="+"
                >
                    {{ __ ('Create page') }}
                </x-button>
            </div>
        </div>
    </x-slot:header>

    <livewire:live-model-list
        :model="\BondarDe\Lox\Models\CmsPage::class"
    />

</x-admin-page>
