<x-page
    :title="__('Change password')"
    :h1="__('Change password')"
>
    <form
        method="post"
        action="{{ route('user.profile.password.update') }}"
    >
        @csrf

        <x-form.form-row
            for="current_password"
            :label="__('Current Password')"
        >
            <x-form.input
                type="password"
                name="current_password"
                :placeholder="__('Current Password')"
                autocomplete="current-password"
            />
        </x-form.form-row>

        <x-form.form-row
            for="new_password"
            :label="__('New Password')"
        >
            <x-form.input
                type="password"
                name="new_password"
                :placeholder="__('New Password')"
                autocomplete="new-password"
            />


            <x-form.input
                containerClass="mt-8"
                type="password"
                name="new_password_confirmation"
                :placeholder="__('Confirm Password')"
                autocomplete="new-password"
            />
        </x-form.form-row>

        <x-form.form-actions>
            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-form.form-actions>

    </form>
</x-page>
