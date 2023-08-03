<x-page
    :title="__('Delete Account')"
    :h1="__('Delete Account')"
>

    <form
        method="post"
        action="{{ route('user.profile.delete-account.delete') }}"
    >
        @csrf

        <input
            type="hidden"
            name="{{ \BondarDe\Lox\Http\Requests\User\Profile\AccountDeleteRequest::INPUT_CONFIRMATION_HASH }}"
            value="{{ $confirmationHash }}"
        >

        <x-form.form-row
            :for="\BondarDe\Lox\Http\Requests\User\Profile\AccountDeleteRequest::INPUT_CONFIRMATION_STRING"
            :label="__('Confirmation')"
        >
            <p>{{ __('Please enter the following symbols to confirm you want to delete your account:') }}</p>

            <p class="text-lg my-4 font-semibold">
                {{ $confirmationString }}
            </p>

            <x-form.input
                containerClass="max-w-sm"
                :name="\BondarDe\Lox\Http\Requests\User\Profile\AccountDeleteRequest::INPUT_CONFIRMATION_STRING"
                :placeholder="__('Confirmation')"
                value=""
                required
            />

        </x-form.form-row>

        <x-form.form-actions>
            <x-button-red>
                {{ __('Delete Account') }}
            </x-button-red>
        </x-form.form-actions>
    </form>

</x-page>
