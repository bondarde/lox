<x-admin-page
    :title="__('Users')"
    :h1="__('Users')"
>
    <x-model-list
        :model="config('auth.providers.users.model')"
    >
        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._users_list', [
            'users' => $component->items,
        ])
    </x-model-list>
</x-admin-page>
