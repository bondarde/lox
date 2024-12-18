<x-lox::page
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

        <x-lox::form.form-row
            :for="\BondarDe\Lox\Http\Requests\User\Profile\AccountDeleteRequest::INPUT_CONFIRMATION_STRING"
            :label="__('Confirmation')"
        >
            <p>{{ __('Please enter the following symbols to confirm you want to delete your account:') }}</p>

            <p class="text-lg my-4 font-semibold">
                {{ $confirmationString }}
            </p>

            <x-lox::form.input
                containerClass="max-w-sm"
                :name="\BondarDe\Lox\Http\Requests\User\Profile\AccountDeleteRequest::INPUT_CONFIRMATION_STRING"
                :placeholder="__('Confirmation')"
                value=""
                required
            />

        </x-lox::form.form-row>

        <x-lox::form.form-actions>
            <x-lox::button
                color="red"
            >
                {{ __('Delete Account') }}
            </x-lox::button>
        </x-lox::form.form-actions>
    </form>

</x-lox::page>
