@if($permissions?->count())
    <ul>
        @foreach($permissions as $permission)
            <li>
                <a
                    class="hover:underline"
                    href="{{ route('admin.user-permissions.show', $permission) }}"
                >
                    {{ $permission->name }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="opacity-50 mb-4">
        {{ $emptyText ?? __('No assigned permissions.') }}
    </p>
@endif
