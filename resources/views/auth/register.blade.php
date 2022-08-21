<x-page
    :title="__('Create new account')"
    :h1="__('Create New Account')"
    metaRobots="noindex, nofollow"
>
    <x-validation-errors
        class="mb-4"
    />

    <form
        method="post"
        action="{{ route('register') }}"
    >
        @csrf

        <x-content class="max-w-xl">

            <x-form.input
                label="{{ __('Name') }}"
                type="text"
                name="{{ \App\Models\User::FIELD_NAME }}"
                :value="old(\App\Models\User::FIELD_NAME)"
                required
                autofocus
                autocomplete="name"
                placeholder="{{ __('Jane Doe') }}"
                tabindex="10"
            />


            <div class="mt-4">
                <x-form.input
                    label="{{ __('E-mail address') }}"
                    type="email"
                    name="{{ \App\Models\User::FIELD_EMAIL }}"
                    :value="old(\App\Models\User::FIELD_NAME)"
                    required
                    placeholder="{{ __('mail@example.com') }}"
                    autocomplete="email"
                    tabindex="10"
                />
            </div>

            <div class="mt-4">
                <x-form.input
                    label="{{ __('Password') }}"
                    type="password"
                    name="{{ \App\Models\User::FIELD_PASSWORD }}"
                    required
                    autocomplete="new-password"
                    :placeholder="__('At least 8 characters')"
                    tabindex="10"
                />
                <p class="mt-1 text-sm opacity-75">
                    {{ __('Please choose as complex password as possible.') }}
                </p>
            </div>

            <div class="mt-4">
                <x-form.input
                    label="{{ __('Confirm password') }}"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password confirmation')"
                    tabindex="10"
                />
                <p class="mt-1 text-sm opacity-75">
                    {{ __('Please confirm your password to avoid errors.') }}
                </p>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                   href="{{ route('login') }}"
                   tabindex="100"
                >
                    {{ __('Already registered?') }}
                </a>

                <x-button
                    class="ml-4"
                    tabindex="10"
                >
                    {{ __('Register') }}
                </x-button>
            </div>
        </x-content>

    </form>
</x-page>
