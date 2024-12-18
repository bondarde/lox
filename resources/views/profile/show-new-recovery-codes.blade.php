<x-lox::page
    :title="$pageTitle"
    :h1="$pageTitle"
>

    <x-lox::content>
        <ul>
            @foreach($recoveryCodes as $code)
                <li>{{ $code }}</li>
            @endforeach
        </ul>
    </x-lox::content>

    <x-lox::button
        tag="a"
        :href="route('user.index')"
    >
        {{ __('I have noted the new recovery codes') }}
    </x-lox::button>

</x-lox::page>
