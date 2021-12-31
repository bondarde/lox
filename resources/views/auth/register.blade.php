<x-page
    title="Registrierung"
    h1="Registrierung"
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
                placeholder="Erika Mustermann"
                tabindex="10"
            />


            <div class="mt-4">
                <x-form.input
                    label="{{ __('Email') }}"
                    type="email"
                    name="{{ \App\Models\User::FIELD_EMAIL }}"
                    :value="old(\App\Models\User::FIELD_NAME)"
                    required
                    placeholder="mail@example.de"
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
                    placeholder="Min. 8 Zeichen"
                    tabindex="10"
                />
                <p class="mt-1 text-sm opacity-75">
                    Bitte wählen Sie ein möglichst komplexes Passwort.
                </p>
            </div>

            <div class="mt-4">
                <x-form.input
                    label="{{ __('Confirm Password') }}"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Passwort-Wiederholung"
                    tabindex="10"
                />
                <p class="mt-1 text-sm opacity-75">
                    Bitte wiederholen Sie das Passwort, um Fehler bei Eingabe auszuschließen.
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
