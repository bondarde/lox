<div {{ $attributes->merge(['class' => 'p-4 flex gap-8 flex-col md:flex-row-reverse']) }}>
    <div class="mb-4 md:w-3/4">
        {{ $slot }}
    </div>
    <div class="mb-4 md:w-1/4">
        {{ $back ?? '' }}
    </div>
</div>
<div class="md:flex p-4 mb-8">
    <div class="mb-4 md:w-1/4">
    </div>
    <div class="md:w-2/4">
        {{ $cancel ?? '' }}
    </div>
</div>
