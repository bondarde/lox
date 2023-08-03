<x-admin-page
    :title="__('Role')"
>
    <x-slot:header>
        <h1 class="mb-2">
            {{ __('Role') }}
        </h1>

        <x-button
            class="mb-8"
            :tag="\BondarDe\Lox\View\Components\Button::TAG_LINK"
            :href="route('admin.user-roles.edit', $role)"
        >
            {{ __('Edit Role') }}
        </x-button>
    </x-slot:header>

    <x-content>
        <p>
            {{ $role->name }}
        </p>
        <p class="opacity-50">
            {{ $role->guard_name }}
        </p>
    </x-content>

    <h2>{{ __('Permissions') }}</h2>
    @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE . '::admin.users._assigned_permissions', ['permissions' => $role->permissions])


    <h2>{{ __('Users') }}</h2>
    @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE . '::admin.users._assigned_users', ['users' => $role->users])

</x-admin-page>
