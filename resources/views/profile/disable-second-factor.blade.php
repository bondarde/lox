<x-page
    :title="$pageTitle"
    :h1="$pageTitle"
>

    <form
        method="post"
        action="{{ route('user.profile.second-factor.disable.confirm') }}"
    >
        @csrf

        <x-form.form-row
            :for="\BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorDisableRequest::CONFIRMATION_CODE"
            label="Code"
        >
            <x-form.input
                containerClass="max-w-xs"
                label="Code"
                placeholder="Code"
                :name="\BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorDisableRequest::CONFIRMATION_CODE"
                value=""
                autofocus
                required
                maxlength="6"
            />
        </x-form.form-row>
        <x-form.form-actions>
            <x-button>
                {{ __('Disable') }}
            </x-button>
        </x-form.form-actions>
    </form>

</x-page>
