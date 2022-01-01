<x-page
    :title="__('Profile')"
    :h1="__('Profile')"
>
    <div class="max-w-xl">
        @includeFirst(['profile._profile-information', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._profile-information'])
        @includeFirst(['profile._password', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._password'])
        @includeFirst(['profile._second-factor', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._second-factor'])
        @includeFirst(['profile._logout-other-browser-sessions', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._logout-other-browser-sessions'], [
            'sessions' => \App\Services\UsersService::getSessions($user),
        ])
        @includeFirst(['profile._delete-account', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._delete-account'])
    </div>
</x-page>
