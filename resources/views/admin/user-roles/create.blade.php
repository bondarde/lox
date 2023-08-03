<x-admin-page
    :title="__('Create New Role')"
    :h1="__('Create New Role')"
>

    <form
        method="post"
        action="{{ route('admin.user-roles.store') }}"
    >
        @csrf

        @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE . '::admin.user-roles._user_role_edit_form', ['model' => null])

        <x-form.form-actions>
            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-form.form-actions>
    </form>

</x-admin-page>
