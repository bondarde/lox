<x-admin-page
    :title="__('User Role')"
    :h1="__('User Role')"
>

    <x-content>
        <p>
            {{ $role->name }}
        </p>
        <p class="opacity-50">
            {{ $role->guard_name }}
        </p>
    </x-content>

    <h2>{{ __('Permissions') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._assigned_permissions', ['permissions' => $role->permissions])


    <h2>{{ __('Users') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._assigned_users', ['users' => $role->users])

</x-admin-page>
