<x-admin-page
    :title="__('Users')"
    :h1="__('Users')"
>
    <livewire:live-model-list
        :model="config('auth.providers.users.model')"
    />
</x-admin-page>
