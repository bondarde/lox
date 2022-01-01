<x-page
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
        <x-content>
            <div class="text-sm">{{ __('Recovery Codes') }}:</div>
            <ul>
                @foreach($recoveryCodes as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        </x-content>
    </div>


    <x-validation-errors
        class="mb-8 max-w-lg"
    />

    <form
        method="post"
        action="{{ route('user.profile.second-factor.enable.confirm') }}"
    >
        @csrf

        <input
            type="hidden"
            name="{{ \BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest::SECRET_KEY }}"
            value="{{ $secretKeyEncrypted }}"
        >

        <input
            type="hidden"
            name="{{ \BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest::RECOVERY_CODES }}"
            value="{{ $recoveryCodesEncrypted }}"
        >

        <x-form.form-row
            :for="\BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest::CONFIRMATION_CODE"
            :label="__('Confirmation Code')"
        >
            <x-form.input
                containerClass="max-w-xs"
                :name="\BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest::CONFIRMATION_CODE"
                :label="__('Confirmation Code')"
                :placeholder="__('Confirmation Code')"
                value=""
                autocomplete="off"
                maxlength="6"
                required
            />
        </x-form.form-row>

        <x-form.form-row
            :for="\BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest::RECOVERY_CODES_STORED"
            :label="__('Recovery codes stored')"
        >
            <x-form.boolean
                :label="__('Recovery codes stored')"
                :placeholder="__('Recovery codes stored')"
                :name="\BondarDe\LaravelToolbox\Http\Requests\User\Profile\SecondFactorEnableRequest::RECOVERY_CODES_STORED"
                :checked="false"
            >
                {{ __('Recovery codes stored') }}
            </x-form.boolean>
        </x-form.form-row>

        <x-form.form-actions>
            <x-button>
                {{ __('Enable') }}
            </x-button>
        </x-form.form-actions>
    </form>

</x-page>
