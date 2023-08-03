<x-admin-page
    :title="__('User') . ' ' . $user->{\BondarDe\Lox\Models\User::FIELD_EMAIL}"
    :h1="__('User') . ' ' . $user->{\BondarDe\Lox\Models\User::FIELD_EMAIL}"
>

    <form
        method="post"
        action="{{ route('admin.users.update', $user) }}"
    >
        @csrf
        @method('PATCH')

        <x-form.form-row
            :for="\BondarDe\Lox\Models\User::FIELD_NAME"
            :label="__('Name')"
        >
            <x-form.input
                :name="\BondarDe\Lox\Models\User::FIELD_NAME"
                :model="$user"
                :placeholder="__('Name')"
            />
        </x-form.form-row>


        <x-form.form-row
            :for="\BondarDe\Lox\Models\User::FIELD_EMAIL"
            :label="__('E-mail address')"
        >
            <x-form.input
                :name="\BondarDe\Lox\Models\User::FIELD_EMAIL"
                :model="$user"
                :placeholder="__('E-mail')"
            />
        </x-form.form-row>


        <x-form.form-row
            :label="__('Roles')"
            :for="\App\Models\User::ATTRIBUTE_ROLES"
        >
            @if(count($roles))
                <x-form.checkbox
                    :isList="true"
                    :name="\App\Models\User::ATTRIBUTE_ROLES"
                    :options="$roles"
                    :value="$activeRoles"
                />
            @else
                <p class="opacity-50">
                    {{ __('No groups available.') }}
                </p>
            @endif
        </x-form.form-row>


        <x-form.form-row
            :label="__('Permissions')"
            :for="\App\Models\User::ATTRIBUTE_PERMISSIONS"
        >
            @if(count($permissions))
                <x-form.checkbox
                    :isList="true"
                    name="permissions"
                    :options="$permissions"
                    :value="$activePermissions"
                />
            @else
                <p class="opacity-50">
                    {{ __('No permissions available.') }}
                </p>
            @endif
        </x-form.form-row>


        <x-form.form-actions>
            <x-button>{{ __('Save') }}</x-button>

            <x-slot name="cancel">
                <x-button-light
                    :tag="\BondarDe\Lox\View\Components\Button::TAG_LINK"
                    :href="route('admin.users.show', $user)"
                >{{ __('Cancel') }}</x-button-light>
            </x-slot>
        </x-form.form-actions>

    </form>

</x-admin-page>
