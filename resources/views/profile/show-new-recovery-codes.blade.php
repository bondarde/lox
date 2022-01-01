<x-page
    :title="$pageTitle"
    :h1="$pageTitle"
>

    <x-content>
        <ul>
            @foreach($recoveryCodes as $code)
                <li>{{ $code }}</li>
            @endforeach
        </ul>
    </x-content>

    <x-button
        :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
        :href="route('profile.show')"
    >
        {{ __('I have noted the new recovery codes') }}
    </x-button>

</x-page>
