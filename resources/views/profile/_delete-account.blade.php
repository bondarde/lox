<h2 class="mt-16">
    {{ __('Delete Account') }}
</h2>
<small>
    {{ __('Permanently delete your account.') }}
</small>

<x-content>
    <p>
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>

    <div class="flex items-center mt-8">
        <x-button-red
            :tag="\BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK"
            :href="route('user.profile.delete-account.confirm')"
        >
            {{ __('Delete Account') }}
        </x-button-red>
    </div>

</x-content>
