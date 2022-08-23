<x-admin-page
    :title="__('Edit User Role')"
    :h1="__('Edit User Role')"
>

    <form
        method="post"
        action="{{ route('admin.user-roles.update', $role) }}"
    >
        @csrf
        @method('PATCH')

        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.user-roles._user_role_edit_form', ['model' => $role])

        <x-form.form-actions>
            <x-button>
                {{ __('Update') }}
            </x-button>
        </x-form.form-actions>
    </form>

</x-admin-page>
