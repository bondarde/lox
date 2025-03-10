<x-lox::page
    title="E-Mail-Bestätigung"
    h1="E-Mail-Bestätigung"
    metaRobots="noindex, nofollow"
>
    <x-lox::content class="max-w-xl">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form
                method="post"
                action="{{ route('verification.send') }}"
            >
                @csrf

                <x-lox::button type="submit">
                    {{ __('Resend Verification Email') }}
                </x-lox::button>
            </form>

            <form
                method="post"
                action="{{ route('logout') }}"
            >
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </x-lox::content>
</x-lox::page>
