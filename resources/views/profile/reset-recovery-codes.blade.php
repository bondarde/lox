<x-page
    :title="$pageTitle"
    :h1="$pageTitle"
>

    <form
        method="post"
        action="{{ route('user.profile.reset-recovery-codes.confirm') }}"
    >
        @csrf

        <x-form.form-row
            :for="\BondarDe\Lox\Http\Requests\User\Profile\RecoveryCodesResetRequest::CONFIRMATION_CODE"
            label="Code"
        >
            <x-form.input
                containerClass="max-w-xs"
                label="Code"
                placeholder="Code"
                :name="\BondarDe\Lox\Http\Requests\User\Profile\RecoveryCodesResetRequest::CONFIRMATION_CODE"
                value=""
                autofocus
                required
                maxlength="6"
            />
        </x-form.form-row>
        <x-form.form-actions>
            <x-button>
                {{ __('Regenerate Recovery Codes') }}
            </x-button>
        </x-form.form-actions>
    </form>

</x-page>
