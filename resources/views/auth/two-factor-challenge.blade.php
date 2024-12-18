<x-lox::page
    title="{{ __('Two Factor Authentication') }}"
    h1="{{ __('Two Factor Authentication') }}"
    metaRobots="noindex, nofollow"
>
    <x-lox::content class="max-w-xl">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </div>

        <x-lox::validation-errors
            class="mb-4"
        />

        <form
            method="post"
            action="{{ route('two-factor.login') }}"
        >
            @csrf

            <div class="mt-4">
                <x-lox::form.input
                    :label="__('Code')"
                    :placeholder="__('Code')"
                    type="text"
                    inputmode="numeric"
                    name="code"
                    autofocus
                    autocomplete="one-time-code"
                />
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-lox::button
                    class="ml-4"
                >
                    {{ __('Login') }}
                </x-lox::button>
            </div>
        </form>
    </x-lox::content>

    <p>
        {{ __('You have no access to your 2FA device?') }}
        <br>
        <a
            class="link"
            href="{{ route('two-factor.recovery') }}"
        >
            {{ __('Use a recovery code') }}
        </a>
    </p>

</x-lox::page>
