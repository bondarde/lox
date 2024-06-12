@aware([
    'showAdminNavigation' => false,
])
<?php

use BondarDe\Lox\Constants\Environment;
use BondarDe\Lox\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

?>
@if(!App::environment(Environment::PROD))
    <div
        class="bg-yellow-200 dark:bg-yellow-900 border-b border-yellow-400 dark:border-yellow-800 text-yellow-800 dark:text-yellow-400 text-sm font-bold py-0.5 shadow"
    >
        <div class="container">
            {{ ucfirst(App::environment()) }} Environment
        </div>
    </div>
@endif

<div class="container pt-4 pb-8 lg:flex gap-4">
    <div class="flex justify-between">
        <ul>
            <x-nav-item
                class="font-extrabold"
                :href="route('home')"
                active-route="home"
            >
                @includeIf('nav.logo')
                {{ config('app.name') }}
            </x-nav-item>
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

                @can('view backend')
                    <x-nav-item
                        :href="route('admin.dashboard')"
                        active-route="admin.*"
                    >
                        Admin
                    </x-nav-item>
                @endcan

                <x-nav-item
                    :href="route('user.index')"
                    active-route="user.*"
                >
                    {{ Auth::user()->{User::FIELD_NAME} }}
                </x-nav-item>
            @endauth
            @guest()
                <x-nav-item
                    :href="route('login')"
                    active-route="login"
                >
                    {{ __('Login') }}
                </x-nav-item>
                @if(Route::has('register'))
                    <x-nav-item
                        :href="route('register')"
                        active-route="register"
                    >
                        {{ __('Register') }}
                    </x-nav-item>
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
