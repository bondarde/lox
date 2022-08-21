<x-page
    :title="__('Login')"
    :h1="__('Login')"
    metaRobots="noindex, nofollow"
>
    <x-validation-errors
        class="max-w-xl mb-8"
    />

    <x-content class="max-w-xl">

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form
            method="post"
            action="{{ route('login') }}"
        >
            @csrf

            <div>
                <x-form.input
                    label="{{ __('E-mail address') }}"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    tabindex="10"
                    autocomplete="email"
                    placeholder="{{ __('E-mail address') }}"
                />
            </div>

            <div class="mt-4">
                <x-form.input
                    label="{{ __('Password') }}"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    tabindex="10"
                    placeholder="{{ __('Password') }}"
                />
            </div>

            <div class="mt-4">
                <label class="flex items-center">
                    <x-form.boolean
                        name="remember"
                        tabindex="10"
                    >
                        {{ __('Remember me') }}
                    </x-form.boolean>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:no-underline hover:text-gray-900"
                       href="{{ route('password.request') }}"
                       tabindex="100"
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button
                    class="ml-4"
                    tabindex="10"
                >
                    {{ __('Login') }}
                </x-button>
            </div>
        </form>
    </x-content>


    <p class="my-8">
        {{ __('You have no account yet?') }}
        <a
            class="underline hover:no-underline whitespace-nowrap"
            href="{{ route('register') }}"
            tabindex="110"
        >
            {{ __('Create new account') }}
        </a>
    </p>

</x-page>
