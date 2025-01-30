<div
    class="text-sm bg-sky-900 text-white
        flex flex-col md:flex-row gap-3 md:gap-6 p-3 md:justify-center md:justify-items-center
    "
>

    <div class="flex flex-col md:flex-row md:items-center gap-2">
        <strong class="font-bold">
            {{ __('filament-impersonate::banner.impersonating') }}
            <strong>{{ $name }}</strong>
        </strong>
    </div>
    <div>
        <a
            class="flex gap-2 items-center
                rounded-full
                border border-sky-800
                text-red-50 bg-gray-950
                hover:bg-gray-800 hover:border-sky-700
                transition
                px-3.5 py-1
                font-bold whitespace-nowrap
                "
            href="{{ route('filament-impersonate.leave') }}"
        >
            <x-filament::icon
                icon="heroicon-m-arrow-left-end-on-rectangle"
                class="size-4"
            />
            <span>{{ __('filament-impersonate::banner.leave') }}</span>
        </a>
    </div>
</div>
