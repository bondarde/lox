<x-page
    :title="__('Password confirmation')"
    :h1="__('Password confirmation')"
>
    <x-content class="max-w-xl">
        <x-validation-errors class="mb-4"/>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form
            method="post"
            action="{{ route('password.confirm') }}"
        >
            @csrf

            <div>
                <x-form.input
                    :label="__('Password')"
                    :placeholder="__('Password')"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-content>
</x-page>
