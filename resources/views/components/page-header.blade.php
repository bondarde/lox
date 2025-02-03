@aware([
    'showAdminNavigation' => false,
])
<?php

use BondarDe\Lox\Constants\Environment;
use BondarDe\Lox\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

?>

<x-lox::banners.environment/>
<x-lox::banners.impersonate/>

<div class="container pt-4 pb-8 lg:flex gap-4">
    <div class="flex justify-between">
        <ul>
            <x-lox::nav-item
                class="font-extrabold"
                :href="route('home')"
                active-route="home"
            >
                @includeIf('nav.logo')
                {{ config('app.name') }}
            </x-lox::nav-item>
        </ul>

        <div>
            <label
                class="bg-white dark:bg-gray-900 px-2 py-1 rounded-lg border dark:border-gray-700 lg:hidden shadow-sm active:bg-gray-100 dark:active:bg-gray-800"
                for="nav-peer"
            >{{ __('Menu') }}</label>
        </div>
    </div>

    <input
        type="checkbox"
        class="hidden peer"
        id="nav-peer"
    >
    <div
        class="hidden lg:flex grow peer-checked:flex flex-col lg:flex-row gap-8 justify-between my-8 lg:my-0"
    >
        <ul class="flex flex-col lg:flex-row gap-4">
            @includeIf('nav.nav')
        </ul>


        <ul class="flex flex-col lg:flex-row gap-4">
            @auth()
                @includeIf('nav.user')

                @can('page_AdminDashboard')
                    <x-lox::nav-item
                        :href="route('filament.admin.pages.dashboard')"
                    >
                        Admin
                    </x-lox::nav-item>
                @endcan

                <x-lox::nav-item
                    :href="route('filament.me.pages.profile')"
                >
                    {{ Auth::user()->{User::FIELD_NAME} }}
                </x-lox::nav-item>
            @endauth
            @guest()
                <x-lox::nav-item
                    :href="route('login')"
                    active-route="login"
                >
                    {{ __('Login') }}
                </x-lox::nav-item>
                @if(Route::has('register'))
                    <x-lox::nav-item
                        :href="route('register')"
                        active-route="register"
                    >
                        {{ __('Register') }}
                    </x-lox::nav-item>
                @endif
            @endguest
        </ul>
    </div>
</div>

@if(isset($showAdminNavigation) && $showAdminNavigation)
    @can('view backend')
        <div class="container mb-8">
            @includeIf('nav.admin')
        </div>
    @endcan
@endif

@includeIf('nav.suffix')

{{ $slot }}
