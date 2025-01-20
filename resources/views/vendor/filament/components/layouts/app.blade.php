@php
    use Filament\Support\Facades\FilamentView;
@endphp

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class([
        'fi min-h-screen',
        'dark' => filament()->hasDarkModeForced(),
    ])
>
    <head>
        {{ \Filament\Support\Facades\FilamentView::renderHook('head.start') }}

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @foreach (\Filament\Facades\Filament::getMeta() as $tag)
            {{ $tag }}
        @endforeach

        @if ($favicon = filament()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
        @endif

        <title>{{ filament()->getBrandName() }}</title>

        {{ \Filament\Support\Facades\FilamentView::renderHook('styles.start') }}

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')

        <!-- GrapeJS -->
        <script src="https://unpkg.com/grapesjs@0.22.5/dist/grapes.min.js"></script>
        <script src="https://unpkg.com/grapesjs-preset-webpage@1.0.3/dist/grapesjs-preset-webpage.min.js"></script>
        <script src="https://unpkg.com/grapesjs-blocks-basic@1.0.1/dist/grapesjs-blocks-basic.min.js"></script>
        <script src="https://unpkg.com/grapesjs-plugin-forms@2.0.6/dist/grapesjs-plugin-forms.min.js"></script>
        <script src="https://unpkg.com/grapesjs-custom-code@1.0.1/dist/grapesjs-custom-code.min.js"></script>
        <script src="https://unpkg.com/grapesjs-style-bg@2.0.1/dist/grapesjs-style-bg.min.js"></script>
        <link href="https://unpkg.com/grapesjs@0.22.5/dist/css/grapes.min.css" rel="stylesheet">

        {{ \Filament\Support\Facades\FilamentView::renderHook('styles.end') }}

    </head>

    <body class="fi-body min-h-screen antialiased">
        {{ \Filament\Support\Facades\FilamentView::renderHook('body.start') }}

        {{ $slot }}

        @livewire(\Livewire\Livewire::getAlias('notifications'))

        {{ \Filament\Support\Facades\FilamentView::renderHook('scripts.start') }}

        @filamentScripts
        @vite('resources/js/app.js')

        @stack('scripts')

        {{ \Filament\Support\Facades\FilamentView::renderHook('scripts.end') }}

        {{ \Filament\Support\Facades\FilamentView::renderHook('body.end') }}
    </body>
</html> 