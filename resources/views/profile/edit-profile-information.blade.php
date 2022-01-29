<x-page
    :title="__('Profile Information')"
    :h1="__('Profile Information')"
>

    <x-validation-errors
        class="mb-8"
    />

    <form
        method="post"
        action="{{ route('user.profile.profile-information.update') }}"
    >
        @csrf

        <x-form.form-row
            :for="\App\Models\User::FIELD_NAME"
            :label="__('Name')"
        >
            <x-form.input
                :name="\App\Models\User::FIELD_NAME"
                :model="$user"
                :placeholder="__('Name')"
                required
                autofocus
            />
        </x-form.form-row>


        <x-form.form-row
            :for="\App\Models\User::FIELD_EMAIL"
            :label="__('Email')"
        >
            <x-form.input
                :name="\App\Models\User::FIELD_EMAIL"
                :model="$user"
                :placeholder="__('Email')"
                required
            />
        </x-form.form-row>


        <x-form.form-actions>
            <x-button>
                {{ __('Update') }}
            </x-button>
        </x-form.form-actions>

    </form>
</x-page>
