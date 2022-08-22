<x-admin-page
    title="User Permission"
    h1="User Permission"
>

    <x-content>
        <p>
            {{ $permission->name }}
        </p>
        <p class="opacity-50">
            {{ $permission->guard_name }}
        </p>
    </x-content>

    <h2>{{ __('Roles') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_roles', ['roles' => $permission->roles])

    <h2>{{ __('Users') }}</h2>
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_users', ['users' => $permission->users])


</x-admin-page>
