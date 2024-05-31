<x-admin-page
    title="Edit Template"
    h1="Edit Template"
>

    <form
        method="post"
        action="{{ route('admin.cms.templates.update', $cmsTemplate) }}"
    >
        @csrf
        @method('PATCH')

        @include('lox::admin.cms.templates._cms-template-edit-form', ['model' => $cmsTemplate])

        <x-form.form-actions>
            <x-button>
                Update
            </x-button>

            <x-slot:cancel>
                <x-button
                    tag="a"
                    :href="route('admin.cms.templates.show', $cmsTemplate)"
                    color="light"
                >
                    Cancel
                </x-button>
            </x-slot:cancel>
        </x-form.form-actions>

    </form>

</x-admin-page>
