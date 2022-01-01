<h2 class="mt-16">
    {{ __('Two Factor Authentication') }}
</h2>
<small>
    {{ __('Add additional security to your account using two factor authentication.') }}
</small>

<x-content>
    <p class="opacity-75">
        {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
    </p>

    <p class="my-4">
        @if($user->{\App\Models\User::FIELD_TWO_FACTOR_SECRET})
            {{ __('You have enabled two factor authentication.') }}
        @else
            {{ __('You have not enabled two factor authentication.') }}
        @endif
    </p>


    <div class="sm:flex sm:space-x-4 items-center mt-8">

        @if($user->{\App\Models\User::FIELD_TWO_FACTOR_SECRET})
            <div class="grow">
                <x-button
                    :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
                    :href="route('user.profile.reset-recovery-codes.start')"
                >
                    {{ __('Regenerate Recovery Codes') }}
                </x-button>
            </div>
            <x-button-red
                class="mt-4 sm:mt-0"
                :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
                :href="route('user.profile.second-factor.disable.start')"
            >
                {{ __('Disable') }}
            </x-button-red>
        @else
            <x-button
                :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
                :href="route('user.profile.second-factor.enable.start')"
            >
                {{ __('Enable') }}
            </x-button>
        @endif
    </div>

</x-content>
