<x-admin-page>

    <x-model-list
        :model="\Spatie\Permission\Models\Permission::class"
    >
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('Permission') }}</th>
                <th>{{ __('Guard') }}</th>
                <th>{{ __('Roles') }}</th>
                <th>{{ __('Users') }}</th>
            </tr>
            </thead>
            @foreach($component->items as $permission)
                <tr class="border-t">
                    <td>
                        <a
                            class="link"
                            href="{{ route('admin.user-permissions.show', $permission) }}"
                        >
                            {{ $permission->name }}
                        </a>
                    </td>
                    <td>
                        {{ $permission->guard_name }}
                    </td>
                    <td>
                        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_roles', ['roles' => $permission->roles, 'emptyText' => '—'])
                    </td>
                    <td>
                        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_users', ['users' => $permission->users, 'emptyText' => '—'])
                    </td>
                </tr>
            @endforeach
        </table>
    </x-model-list>

</x-admin-page>
