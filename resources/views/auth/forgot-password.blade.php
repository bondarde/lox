<x-lox::page
    :title="__('Forgot your password?')"
    :h1="__('Forgot your password?')"
    metaRobots="noindex, nofollow"
>
    <x-lox::content class="max-w-xl">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('You forgot your password? No problem. Just let us know your e-mail address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-lox::validation-errors class="mb-4"/>

        <form
            method="post"
            action="{{ route('password.email') }}"
        >
            @csrf

            <div>
                <x-lox::form.input
                    :label="__('E-mail address')"
                    :placeholder="__('mail@example.com')"
                    type="email"
                    name="email"
                    autocomplete="email"
                    :value="old('email')"
                    required
                    autofocus
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-lox::button>
                    {{ __('Email password reset link') }}
                </x-lox::button>
            </div>
        </form>
    </x-lox::content>

    <a
        class="underline opacity-75 hover:no-underline hover:opacity-100"
        href="{{ route('login') }}"
    >
        {{ __('Did you recognize your password?') }}
    </a>
</x-lox::page>
