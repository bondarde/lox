<x-lox::page
    :title="__('Change password')"
    :h1="__('Change password')"
>
    <form
        method="post"
        action="{{ route('user.profile.password.update') }}"
    >
        @csrf

        <x-lox::form.form-row
            for="current_password"
            :label="__('Current Password')"
        >
            <x-lox::form.input
                type="password"
                name="current_password"
                :placeholder="__('Current Password')"
                autocomplete="current-password"
            />
        </x-lox::form.form-row>

        <x-lox::form.form-row
            for="new_password"
            :label="__('New Password')"
        >
            <x-lox::form.input
                type="password"
                name="new_password"
                :placeholder="__('New Password')"
                autocomplete="new-password"
            />


            <x-lox::form.input
                containerClass="mt-8"
                type="password"
                name="new_password_confirmation"
                :placeholder="__('Confirm Password')"
                autocomplete="new-password"
            />
        </x-lox::form.form-row>

        <x-lox::form.form-actions>
            <x-lox::button>
                {{ __('Save') }}
            </x-lox::button>
        </x-lox::form.form-actions>

    </form>
</x-lox::page>
