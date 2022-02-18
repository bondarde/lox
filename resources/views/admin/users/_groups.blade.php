<div class="mb-8">
    @if(optional($groups)->count())
        <ul>
            @foreach($groups as $group)
                <li>
                    {{ $group->name }}
                    <div class="text-sm opacity-75 mb-2">
                        {{ $group->description }}
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="opacity-50 mb-4">
            {{ __('No assigned groups.') }}
        </p>
    @endif
</div>
