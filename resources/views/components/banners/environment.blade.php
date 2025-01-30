<div
    class="text-sm bg-amber-900 text-white
        flex flex-col md:flex-row gap-3 md:gap-6 p-3 md:justify-center md:justify-items-center
    "
    id="lox-banner-environment"
>
    <div class="flex flex-col md:flex-row md:items-center gap-2">
        <strong class="font-bold">
            {{ $label }} Environment
        </strong>
        <div class="hidden md:block">·</div>
        <div>
            Your data can get lost any time
        </div>
    </div>
    <div>
        <button
            class="flex gap-2 items-center
                rounded-full
                border border-amber-800
                text-red-50 bg-gray-950
                hover:bg-gray-800 hover:border-amber-700
                transition
                px-3.5 py-1
                font-bold whitespace-nowrap
                "
            onclick="document.getElementById('lox-banner-environment').style.display = 'none'"
        >
            <span>OK</span>
            <x-filament::icon
                icon="heroicon-m-hand-thumb-up"
                class="size-4"
            />
        </button>
    </div>
</div>
