<x-page
    title="Passwort vergessen"
    h1="Passwort vergessen"
    metaRobots="noindex, nofollow"
>
    <x-content class="max-w-xl">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4"/>

        <form
            method="post"
            action="{{ route('password.email') }}"
        >
            @csrf

            <div>
                <x-form.input
                    :label="__('Email')"
                    :placeholder="__('Email')"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-content>
</x-page>
