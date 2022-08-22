@if($roles?->count())
    <ul>
        @foreach($roles as $role)
            <li>
                <a
                    class="hover:underline"
                    href="{{ route('admin.user-roles.show', $role) }}"
                >
                    {{ $role->name }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="opacity-50 mb-4">
        {{ $emptyText ?? __('No assigned roles.') }}
    </p>
@endif
