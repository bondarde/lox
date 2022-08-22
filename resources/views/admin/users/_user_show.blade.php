<x-slot name="header">
    <h1>
        {{ __('User') . ' ' . $user->{\BondarDe\LaravelToolbox\Models\User::FIELD_EMAIL} }}
    </h1>

    <x-button
        class="mt-2 mb-8"
        :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
        :href="route('admin.users.edit', $user)"
    >{{ __('Edit user') }}</x-button>
</x-slot>

<x-model-summary
    :model="$user"
/>


<h2>{{ __('Roles') }}</h2>
<div class="mb-8">
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_roles', ['roles' => $user->roles])
</div>


<h2>{{ __('Permissions') }}</h2>
<div class="mb-8">
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_permissions', ['permissions' => $user->permissions])
</div>


<h2>{{ __('All Permissions') }}</h2>
<div class="mb-8">
    @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::admin.users._assigned_permissions', ['permissions' => $user->allPermissions])
</div>
