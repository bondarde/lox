<table class="table">
    <thead>
    <tr>
        <th>{{ __('Name') }}</th>
        <th>{{ __('E-Mail Address') }}</th>
        <th>{{ __('Groups') }}</th>
        <th>{{ __('Permissions') }}</th>
    </tr>
    </thead>
    @foreach($users as $user)
        <tr class="border-t">
            <td>
                <a
                    class="underline hover:no-underline"
                    href="{{ route('admin.users.show', $user) }}"
                >
                    {{ $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_NAME} }}
                </a>
            </td>
            <td>
                {{ $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_EMAIL} }}
            </td>
            <td>
                @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._groups', ['groups' => $user->groups])
            </td>
            <td>
                @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._permissions', ['permissions' => $user->permissions])
            </td>
        </tr>
    @endforeach
</table>
