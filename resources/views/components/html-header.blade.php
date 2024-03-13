<link rel="apple-touch-icon" sizes="57x57" href="/img/favicons/favicon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/img/favicons/favicon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/img/favicons/favicon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/img/favicons/favicon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/img/favicons/favicon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/img/favicons/favicon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/img/favicons/favicon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/img/favicons/favicon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/favicon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="/img/favicons/favicon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/img/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/img/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/favicons/favicon-16x16.png">
<link rel="canonical" href="{{ URL::current() }}">
<meta property="og:url" content="{{ URL::current() }}"/>
<meta property="og:type" content="website">
@if($title)
    <meta property="og:title" content="{{ $title }} — {{ config('app.name') }}">
@endif
@if($metaDescription)
    <meta property="og:description" content="{{ $metaDescription }}">
@endif
@if($shareImage)
    <meta property="og:image" content="{{ $shareImage }}">
@endif
