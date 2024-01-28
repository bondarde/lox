<x-admin-page
    :title="__('Edit CMS Page')"
    :h1="__('Edit CMS Page')"
>

    <form
        method="post"
        action="{{ route('admin.cms-pages.update', $cmsPage) }}"
    >
        @csrf
        @method('patch')

        @include('lox::admin.cms.pages._cms-page-edit-form', ['model' => $cmsPage])

        <x-form.form-actions>
            <x-button>
                {{ __('Save') }}
            </x-button>

            <x-slot:cancel>
                <x-button
                    color="light"
                    tag="a"
                    :href="route('admin.cms-pages.show', $cmsPage)"
                >
                    {{ __('Cancel') }}
                </x-button>
            </x-slot:cancel>
        </x-form.form-actions>
    </form>

</x-admin-page>
