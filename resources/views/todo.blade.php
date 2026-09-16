@php
    $currentTheme = session('theme', 'default');
@endphp

@include("themes." . $currentTheme)