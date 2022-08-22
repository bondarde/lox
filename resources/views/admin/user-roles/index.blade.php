<x-admin-page>

    <x-model-list
        :model="\Spatie\Permission\Models\Role::class"
    >
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('Role') }}</th>
                <th>{{ __('Guard') }}</th>
                <th>{{ __('Permissions') }}</th>
                <th>{{ __('Users') }}</th>
            </tr>
            </thead>
            @foreach($component->items as $role)
                <tr class="border-t">
                    <td>
                        <a
                            class="link"
                            href="{{ route('admin.user-roles.show', $role) }}"
                        >
                            {{ $role->name }}
                        </a>
                    </td>
                    <td>
                        {{ $role->guard_name }}
                    </td>
                    <td>
                        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._assigned_permissions', ['permissions' => $role->permissions, 'emptyText' => '—'])
                    </td>
                    <td>
                        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._assigned_users', ['users' => $role->users, 'emptyText' => '—'])
                    </td>
                </tr>
            @endforeach
        </table>
    </x-model-list>

    <x-button-green
        :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
        :href="route('admin.user-roles.create')"
    >
        {{ __('Create New Role') }}
    </x-button-green>

</x-admin-page>
