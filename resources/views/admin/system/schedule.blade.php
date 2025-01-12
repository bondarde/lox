<x-filament-panels::page>

    <div>
        {{ $this->table }}
    </div>

    <p class="opacity-65 hover:opacity-100">
        PHP Binary: {{ \Illuminate\Console\Application::phpBinary() }}
        <br>
        Artisan Binary: {{ \Illuminate\Console\Application::artisanBinary() }}
    </p>

</x-filament-panels::page>
