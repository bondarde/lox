<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title>{{ trim(config('page.title.prefix', '') . ' ' . $title . config('page.title.suffix', ' - '.config('app.name'))) }}</title>

    @if($metaDescription)
        <meta name="description" content="{{ $metaDescription }}">
    @endif

    <meta name="robots" content="{{ $metaRobots }}">

    @foreach($cssFiles as $file)
        @if(\Illuminate\Support\Facades\App::environment(\BondarDe\LaravelToolbox\Constants\Environment::LOCAL))
            @vite([$file], '../.build/.vite')
        @else
            <link rel="stylesheet" href="{{ $file }}">
        @endif
    @endforeach
    @if($livewire)
        @livewireStyles
    @endif

    <x-html-header
        :title="$title"
        :metaDescription="$metaDescription"
        :shareImage="$shareImage"
    />
</head>
<body class="antialiased overflow-x-hidden {{ $background }} {{ $text }}">
<div class="{{ $height }}">
    <x-page-header/>

    <div class="container">
        @if($h1)
            <h1>{{ $h1 }}</h1>
        @endif
        {!! $header ?? '' !!}
        <x-user-messages/>
    </div>

    <div class="{{ $attributes->get('contentCssClasses', '') }} {{ $wrapContent ? 'container py-10' : '' }}">
        {{ $slot }}
    </div>
</div>

@stack('modals')

<x-page-footer
    :breadcrumbAttr="$breadcrumbAttr"
/>

@if($livewire)
    @livewireScripts
@endif

@foreach($jsFiles as $file)
    @if(\Illuminate\Support\Facades\App::environment(\BondarDe\LaravelToolbox\Constants\Environment::LOCAL))
        @vite([$file], '../.build/.vite')
    @else
        <script type="module" src="{{ $file }}"></script>
    @endif
@endforeach

</body>
</html>
