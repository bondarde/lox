@error($for)
<p {{ $attributes->merge(['class' => 'font-semibold text-red-600']) }}>{{ $message }}</p>
@enderror
