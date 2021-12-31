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


    <div class="flex items-center mt-8">

        @if($user->{\App\Models\User::FIELD_TWO_FACTOR_SECRET})
        @else
            <x-button type="button" wire:loading.attr="disabled">
                {{ __('Enable') }}
            </x-button>
        @endif
    </div>

</x-content>
