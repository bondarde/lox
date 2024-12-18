<x-lox::page
    :title="__('Profile')"
    :h1="__('Profile')"
>
    <div class="max-w-xl">
        @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::profile._profile-information')
        @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::profile._password')
        @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::profile._second-factor')
        @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::profile._logout-other-browser-sessions', compact('sessions'))

        @if(config('lox.profile.allow-delete'))
            @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::profile._delete-account')
        @endif

    </div>
</x-lox::page>
