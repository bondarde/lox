<x-page
    :title="__('Users')"
    :h1="__('Users')"
>
    <x-model-list
        :model="\BondarDe\LaravelToolbox\Models\User::class"
    >
        @includeFirst(['admin.users._users_list', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._users_list'], [
            'users' => $component->items,
        ])
    </x-model-list>
</x-page>
