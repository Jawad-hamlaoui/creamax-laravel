@props([
    'title',
    'description',
    'robots' => 'index, follow',
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">

<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ url()->current() }}">

<link rel="canonical" href="{{ url()->current() }}">
