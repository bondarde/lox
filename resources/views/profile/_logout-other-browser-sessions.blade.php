<h2 class="mt-16">
    {{ __('Browser Sessions') }}
</h2>
<small>
    {{ __('Manage and log out your active sessions on other browsers and devices.') }}
</small>

<x-content>
    <p>
        {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
    </p>


    @if (count($sessions) > 0)
        <div class="mt-5 space-y-6">
            {{-- Other Browser Sessions --}}
            @foreach ($sessions as $session)
                <div class="flex items-center">
                    <div>
                        @if ($session->agent->isDesktop())
                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                 class="w-8 h-8 text-gray-500">
                                <path d="M0 0h24v24H0z" stroke="none"></path>
                                <rect x="7" y="4" width="10" height="16" rx="1"></rect>
                                <path d="M11 5h2M12 17v.01"></path>
                            </svg>
                        @endif
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600">
                            {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ $session->ip_address }},

                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8 sm:flex sm:space-x-8 items-center">
        <form
            class="grow"
            method="post"
            action="{{ route('user.profile.logout-other-browser-sessions') }}"
        >
            @csrf
            <x-button>
                {{ __('Log Out Other Browser Sessions') }}
            </x-button>
        </form>

        <form
            class="mt-8 sm:mt-0"
            method="post"
            action="{{ route('logout') }}"
        >
            @csrf
            <x-button
                color="red"
            >
                {{ __('Logout') }}
            </x-button>
        </form>
    </div>

</x-content>
