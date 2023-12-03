<x-admin-page
    :title="__('Redirects')"
    :h1="__('Redirects')"
>

    <livewire:live-model-list
        :model="\BondarDe\Lox\Models\CmsRedirect::class"
    />

</x-admin-page>
