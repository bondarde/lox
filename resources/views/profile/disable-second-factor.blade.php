<x-lox::page
    :title="$pageTitle"
    :h1="$pageTitle"
>

    <form
        method="post"
        action="{{ route('user.profile.second-factor.disable.confirm') }}"
    >
        @csrf

        <x-lox::form.form-row
            :for="\BondarDe\Lox\Http\Requests\User\Profile\SecondFactorDisableRequest::CONFIRMATION_CODE"
            label="Code"
        >
            <x-lox::form.input
                containerClass="max-w-xs"
                label="Code"
                placeholder="Code"
                :name="\BondarDe\Lox\Http\Requests\User\Profile\SecondFactorDisableRequest::CONFIRMATION_CODE"
                value=""
                autofocus
                required
                maxlength="6"
            />
        </x-lox::form.form-row>
        <x-lox::form.form-actions>
            <x-lox::button>
                {{ __('Disable') }}
            </x-lox::button>
        </x-lox::form.form-actions>
    </form>

</x-lox::page>
