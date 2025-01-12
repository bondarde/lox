<h2 class="mt-16">
    {{ __('Update Password') }}
</h2>

<x-lox::content>
    <p>
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <div class="flex items-center mt-4">
        @if(Laravel\Fortify\Features::updatePasswords())
            <x-lox::button
                tag="a"
                :href="route('user.profile.password.edit')"
            >
                {{ __('Update Password') }}
            </x-lox::button>
        @endif
    </div>
</x-lox::content>
