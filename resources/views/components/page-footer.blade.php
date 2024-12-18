<div class="container my-8">
    <div class="p-4 pb-8 bg-gradient-to-br from-brand-1 to-brand-2 rounded shadow">
        © {{ date('Y') }}
        <a
            href="{{ route('home') }}"
        >{{ config('app.name') }}</a>

        @can('view rendering stats')
            <x-lox::rendering-stats
                class="mt-8 text-sm opacity-50 hover:opacity-100"
            />
        @endcan
    </div>
</div>
