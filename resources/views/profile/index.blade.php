<x-page
    :title="__('Profile')"
    :h1="__('Profile')"
>
    <div class="max-w-xl">
        @includeFirst(['vendor.bondarde.laravel-toolbox.profile._profile-information', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._profile-information'])
        @includeFirst(['vendor.bondarde.laravel-toolbox.profile._password', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._password'])
        @includeFirst(['vendor.bondarde.laravel-toolbox.profile._second-factor', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._second-factor'])
        @includeFirst(['vendor.bondarde.laravel-toolbox.profile._logout-other-browser-sessions', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._logout-other-browser-sessions'], compact('sessions'))
        @includeFirst(['vendor.bondarde.laravel-toolbox.profile._delete-account', \BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::profile._delete-account'])
    </div>
</x-page>
