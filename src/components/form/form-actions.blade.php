<div {{ $attributes->merge(['class' => 'p-4 mb-8 md:flex']) }}>
    <div class="mb-4 md:w-1/4">
    </div>
    <div class="md:w-3/4">
        {{ $slot }}
    </div>
</div>
