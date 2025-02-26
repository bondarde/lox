<x-lox::page
    :title="$pageTitle"
    :h1="$pageTitle"
>

    <span class="inline-block shadow bg-white">
        {!! $svg !!}
    </span>

    <div class="mb-8">
        <div class="text-sm">{{ __('Secret Key') }}:</div>
        <div class="text-md font-semibold">
            {{ $secretKey }}
        </div>
    </div>

    <div class="mb-8 max-w-md">
        <x-lox::content>
            <div class="text-sm">{{ __('Recovery Codes') }}:</div>
            <ul>
                @foreach($recoveryCodes as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        </x-lox::content>
    </div>


    <x-lox::validation-errors
        class="mb-8 max-w-lg"
    />

    <form
        method="post"
        action="{{ route('user.profile.second-factor.enable.confirm') }}"
    >
        @csrf

        <input
            type="hidden"
            name="{{ \BondarDe\Lox\Http\Requests\User\Profile\SecondFactorEnableRequest::SECRET_KEY }}"
            value="{{ $secretKeyEncrypted }}"
        >

        <input
            type="hidden"
            name="{{ \BondarDe\Lox\Http\Requests\User\Profile\SecondFactorEnableRequest::RECOVERY_CODES }}"
            value="{{ $recoveryCodesEncrypted }}"
        >

        <x-lox::form.form-row
            :for="\BondarDe\Lox\Http\Requests\User\Profile\SecondFactorEnableRequest::CONFIRMATION_CODE"
            :label="__('Confirmation Code')"
        >
            <x-lox::form.input
                containerClass="max-w-xs"
                :name="\BondarDe\Lox\Http\Requests\User\Profile\SecondFactorEnableRequest::CONFIRMATION_CODE"
                :label="__('Confirmation Code')"
                :placeholder="__('Confirmation Code')"
                value=""
                autocomplete="off"
                maxlength="6"
                required
            />
        </x-lox::form.form-row>

        <x-lox::form.form-row
            :for="\BondarDe\Lox\Http\Requests\User\Profile\SecondFactorEnableRequest::RECOVERY_CODES_STORED"
            :label="__('Recovery codes stored')"
        >
            <x-lox::form.boolean
                :label="__('Recovery codes stored')"
                :placeholder="__('Recovery codes stored')"
                :name="\BondarDe\Lox\Http\Requests\User\Profile\SecondFactorEnableRequest::RECOVERY_CODES_STORED"
                :checked="false"
            >
                {{ __('I have stored the above recovery codes') }}
            </x-lox::form.boolean>
        </x-lox::form.form-row>

        <x-lox::form.form-actions>
            <x-lox::button>
                {{ __('Enable') }}
            </x-lox::button>
        </x-lox::form.form-actions>
    </form>

</x-lox::page>
