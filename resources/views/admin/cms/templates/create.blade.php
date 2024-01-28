<x-admin-page
    title="Create Template"
    h1="Create Template"
>

    <form
        method="post"
        action="{{ route('admin.cms-templates.store') }}"
    >
        @csrf

        @include('lox::admin.cms.templates._cms-template-edit-form', ['model' => null])

        <x-form.form-actions>
            <x-button
                color="green"
            >
                Create
            </x-button>
        </x-form.form-actions>

    </form>

</x-admin-page>
