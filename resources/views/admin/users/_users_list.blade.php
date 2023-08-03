<table class="table">
    <thead>
    <tr>
        <th>{{ __('Name') }}</th>
        <th>{{ __('E-Mail Address') }}</th>
        <th>{{ __('Roles') }}</th>
        <th>{{ __('Permissions') }}</th>
    </tr>
    </thead>
    @foreach($users as $user)
        <tr class="border-t">
            <td>
                <a
                    class="link"
                    href="{{ route('admin.users.show', $user) }}"
                >
                    {{ $user->{\BondarDe\Lox\Models\User::FIELD_NAME} }}
                </a>
            </td>
            <td>
                <a
                    href="{{ route('admin.users.show', $user) }}"
                >
                    {{ $user->{\BondarDe\Lox\Models\User::FIELD_EMAIL} }}
                </a>
            </td>
            <td>
                @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::admin.users._assigned_roles', ['roles' => $user->roles, 'emptyText' => '—'])
            </td>
            <td>
                @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::admin.users._assigned_permissions', ['permissions' => $user->permissions, 'emptyText' => '—'])
            </td>
        </tr>
    @endforeach
</table>
