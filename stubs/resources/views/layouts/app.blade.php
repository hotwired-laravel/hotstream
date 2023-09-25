<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['native' => request()->wasFromTurboNative()])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <x-importmap-tags />
        <link rel="stylesheet" href="{{ tailwindcss('css/app.css') }}" />
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <x-banner />

        <div class="min-h-screen">
            <x-navigation-menu />
            <x-notifications />

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
    </body>
</html>
