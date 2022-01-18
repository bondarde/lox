<x-page
    title="Passwort zurücksetzen"
    h1="Passwort zurücksetzen"
    metaRobots="noindex, nofollow"
>
    <div class="container">
        <x-validation-errors/>
    </div>

    <x-content class="max-w-xl">
        <form
            method="post"
            action="{{ route('password.update') }}"
        >
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-form.input
                    :label="__('Email')"
                    :placeholder="__('Email')"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                />
            </div>

            <div class="mt-4">
                <x-form.input
                    type="password"
                    :label="__('Password')"
                    :placeholder="__('Password')"
                    name="password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="mt-4">
                <x-form.input
                    type="password"
                    :label="__('Confirm Password')"
                    :placeholder="__('Confirm Password')"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-content>
</x-page>
