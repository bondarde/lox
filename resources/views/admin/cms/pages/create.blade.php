<x-admin-page
    :title="__('New CMS Page')"
    :h1="__('New CMS Page')"
>

    <form
        method="post"
        action="{{ route('admin.cms-pages.store') }}"
    >
        @csrf

        @include('lox::admin.cms.pages._cms-page-edit-form', ['model' => null])

        <x-form.form-actions>
            <x-button
                color="green"
                icon="+"
            >
                {{ __('Create') }}
            </x-button>
        </x-form.form-actions>
    </form>

</x-admin-page>
