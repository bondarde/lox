<div
    id="lox-livewire-expired-banner"
    style="display: none"
>
    <div class="text-sm bg-pink-900 text-white
        flex flex-col md:flex-row gap-3 md:gap-6 p-3 md:justify-center md:justify-items-center
    ">
        <div class="flex flex-col md:flex-row md:items-center gap-2">
            <strong class="font-bold">
                Session Expired
            </strong>
            <div class="hidden md:block">·</div>
            <div>
                Your session has expired. Please refresh the page to continue.
            </div>
        </div>
        <div>
            <button
                class="flex gap-2 items-center
                rounded-full
                border border-pink-800
                text-red-50 bg-gray-950
                hover:bg-gray-800 hover:border-red-700
                transition
                px-3.5 py-1
                font-bold whitespace-nowrap
                group"
                onclick="location.reload()"
            >
                <span>Refresh page</span>
                <x-filament::icon
                    icon="heroicon-m-arrow-path"
                    class="size-4 group-hover:animate-spin"
                />
            </button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        let sessionExpiredNotified = false;

        Livewire.hook('request', ({fail}) => {
            fail(({status, preventDefault}) => {
                if (status === 419) {
                    preventDefault()

                    if (sessionExpiredNotified) {
                        return
                    }

                    sessionExpiredNotified = true;

                    document.getElementById('lox-livewire-expired-banner').style.display = 'block'
                }
            })
        })
    })
</script>
