<div {{ $attributes->merge(['class' => 'p-4 flex flex-col-reverse md:flex-row']) }}>
    <div class="mb-4 w-full md:w-1/4">
        {{ $back ?? '' }}
    </div>
    <div class="mb-4 w-full md:w-3/4">
        {{ $slot }}
    </div>
    <div>
    </div>
</div>
<div class="md:flex p-4 mb-8">
    <div class="mb-4 md:w-1/4">
    </div>
    <div class="md:w-2/4">
        {{ $cancel ?? '' }}
    </div>
</div>
