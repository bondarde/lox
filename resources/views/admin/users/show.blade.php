<x-admin-page
    :title="__('User') . ' ' . $user->{\BondarDe\Lox\Models\User::FIELD_EMAIL}"
>

    @include(\BondarDe\Lox\LoxServiceProvider::NAMESPACE . '::admin.users._user_show', [
        'user' => $user,
    ])

</x-admin-page>
