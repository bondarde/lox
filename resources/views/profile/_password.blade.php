<h2 class="mt-16">
    {{ __('Update Password') }}
</h2>

<x-content>
    <p>
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <div class="flex items-center mt-4">
        @if(Laravel\Fortify\Features::updatePasswords())
            <x-button
                :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
                :href="route('user.profile.password.edit')"
            >
                {{ __('Update Password') }}
            </x-button>
        @endif
    </div>
</x-content>
