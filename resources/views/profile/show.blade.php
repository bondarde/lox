<x-page
    :title="__('Profile')"
    :h1="__('Profile')"
>
    <div class="max-w-xl">
        @include('profile._profile-information')
        @include('profile._password')
        @include('profile._second-factor')
        @include('profile._logout-other-browser-sessions', [
            'sessions' => \App\Services\UsersService::getSessions($user),
        ])
        @include('profile._delete-account')
    </div>
</x-page>
