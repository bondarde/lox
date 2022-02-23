<x-admin-page
    :title="__('User') . ' ' . $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_EMAIL}"
    :h1="__('User') . ' ' . $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_EMAIL}"
>

    <x-slot name="header">
        <x-button
            :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
            :href="route('admin.users.edit', $user)"
        >{{ __('Edit user') }}</x-button>
    </x-slot>

    <x-model-summary
        :model="$user"
    />


    <h2>{{ __('Groups') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._groups', ['groups' => $user->groups])


    <h2>{{ __('Permissions') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._permissions', ['permissions' => $user->permissions])


    <h2>{{ __('All Permissions') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._permissions', ['permissions' => $user->allPermissions])


</x-admin-page>
