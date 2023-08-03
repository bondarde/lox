<x-page
    :title="__('Profile')"
    :h1="__('Profile')"
>
    <div class="max-w-xl">
        @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::profile._profile-information')
        @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::profile._password')
        @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::profile._second-factor')
        @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::profile._logout-other-browser-sessions', compact('sessions'))

        @if(config('lox.profile.allow-delete'))
            @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE.'::profile._delete-account')
        @endif

    </div>
</x-page>
