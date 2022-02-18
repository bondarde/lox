<div class="mb-8">
    @if(optional($permissions)->count())
        <ul>
            @foreach($permissions as $permission)
                <li>
                    {{ $permission->name }}
                    <div class="text-sm opacity-75 mb-2">
                        {{ $permission->description }}
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="opacity-50 mb-4">
            {{ __('No assigned permissions.') }}
        </p>
    @endif
</div>
