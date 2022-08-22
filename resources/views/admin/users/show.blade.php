<x-admin-page
    :title="__('User') . ' ' . $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_EMAIL}"
    :h1="__('User') . ' ' . $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_EMAIL}"
>

    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE . '::admin.users._user_show', [
        'user' => $user,
    ])

</x-admin-page>
