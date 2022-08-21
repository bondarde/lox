<x-page
    :title="__('Profile')"
    :h1="__('Profile')"
>
    <div class="max-w-xl">
        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._profile-information')
        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._password')
        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._second-factor')
        @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._logout-other-browser-sessions', compact('sessions'))
    </div>
</x-page>
