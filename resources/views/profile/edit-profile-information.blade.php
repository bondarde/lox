<x-lox::page
    :title="__('Profile Information')"
    :h1="__('Profile Information')"
>

    <x-lox::validation-errors
        class="mb-8"
    />

    <form
        method="post"
        action="{{ route('user.profile.profile-information.update') }}"
    >
        @csrf

        <x-lox::form.form-row
            :for="\App\Models\User::FIELD_NAME"
            :label="__('Name')"
        >
            <x-lox::form.input
                :name="\App\Models\User::FIELD_NAME"
                :model="$user"
                :placeholder="__('Name')"
                required
                autofocus
            />
        </x-lox::form.form-row>


        <x-lox::form.form-row
            :for="\App\Models\User::FIELD_EMAIL"
            :label="__('Email')"
        >
            <x-lox::form.input
                :name="\App\Models\User::FIELD_EMAIL"
                :model="$user"
                :placeholder="__('Email')"
                required
            />
        </x-lox::form.form-row>


        <x-lox::form.form-actions>
            <x-lox::button>
                {{ __('Update') }}
            </x-lox::button>
        </x-lox::form.form-actions>

    </form>
</x-lox::page>
