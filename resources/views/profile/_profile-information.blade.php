<h2>{{ __('Profile Information') }}</h2>
<small>
    {{ __('Update your account’s profile information and email address.') }}
</small>

<x-lox::content>
    <div>
        <small>{{ __('Name') }}</small>
        <div class="font-semibold">{{ $user->{\App\Models\User::FIELD_NAME} }}</div>
    </div>

    <div class="mt-4">
        <small>{{ __('E-mail address') }}</small>
        <div class="font-semibold">{{ $user->{\App\Models\User::FIELD_EMAIL} }}</div>
    </div>

    <div class="flex items-center mt-4">
        @if(Laravel\Fortify\Features::canUpdateProfileInformation())
            <x-lox::button
                tag="a"
                :href="route('user.profile.profile-information.edit')"
            >
                {{ __('Edit') }}
            </x-lox::button>
        @endif
    </div>
</x-lox::content>
