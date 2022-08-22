@if($users?->count())
    <ul>
        @foreach($users as $user)
            <li>
                <a
                    class="group"
                    href="{{route('admin.users.show', $user) }}"
                >
                    <span
                        class="group-hover:underline"
                    >{{ $user->{\App\Models\User::FIELD_NAME} }}</span>
                    <span
                        class="text-sm opacity-50"
                    >{{ $user->{\App\Models\User::FIELD_EMAIL} }}</span>
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="opacity-50">
        {{ $emptyText ?? __('No assigned users.') }}
    </p>
@endif
