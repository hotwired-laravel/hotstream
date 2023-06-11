<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <x-importmap-tags />
        <link rel="stylesheet" href="{{ tailwindcss('css/app.css') }}" />
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}" data-turbo-action="replace" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <x-application-mark class="h-16" />
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="https://turbo.hotwired.dev/reference/drive" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-sky-50 dark:bg-yellow-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-sky-500 dark:stroke-yellow-500">
                                        <circle class="st0" cx="4" cy="13.8" r="2"/>
                                        <circle class="st0" cx="4" cy="3.9" r="2"/>
                                        <path d="M2,7.9h13.8c1.1,0,2-0.9,2-2V2c0-1.1-0.9-2-2-2H2C0.9,0,0,0.9,0,2v3.9C0,7,0.9,7.9,2,7.9z M4,2c1.1,0,2,0.9,2,2s-0.9,2-2,2
                                            S2,5,2,3.9S2.9,2,4,2z"/>
                                        <path d="M16.7,12.8c0.3,0,0.7,0.1,1,0.1v-1.1c0-1.1-0.9-2-2-2H2c-1.1,0-2,0.9-2,2v3.9c0,1.1,0.9,2,2,2h11c-0.1-0.3-0.1-0.6-0.1-1
                                            C12.8,14.5,14.6,12.8,16.7,12.8z M4,15.7c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S5,15.7,4,15.7z"/>
                                        <path d="M19.5,16.6c-0.3,0.1-0.7,0.2-1.1,0.3c0-0.1,0-0.3,0-0.4c0.4-0.3,0.7-0.7,0.9-1.1c0.1-0.2,0.1-0.4-0.1-0.6
                                            c-0.2-0.1-0.4-0.1-0.6,0.1c-0.2,0.3-0.3,0.5-0.6,0.7c-0.1-0.1-0.2-0.2-0.3-0.3c0-0.2,0-0.5-0.1-0.7c-0.1-0.3-0.1-0.6-0.3-0.9
                                            c-0.1-0.2-0.3-0.3-0.5-0.2c0,0,0,0,0,0c-0.1,0-0.1,0.1-0.1,0.1c-0.1,0.1-0.1,0.3-0.1,0.4c0,0.1,0.1,0.2,0.1,0.3
                                            c0,0.1,0.1,0.3,0.1,0.4c0,0.1,0,0.3,0.1,0.4c-0.1,0-0.3,0-0.4,0c-0.3-0.4-0.7-0.7-1.1-0.9c-0.2-0.1-0.4,0-0.6,0.1
                                            c-0.1,0.2-0.1,0.4,0.1,0.5c0.3,0.2,0.5,0.3,0.7,0.5c-0.1,0.1-0.2,0.2-0.3,0.3c-0.6,0-1.1,0.1-1.6,0.3c-0.2,0.1-0.3,0.3-0.2,0.5
                                            c0.1,0.2,0.3,0.3,0.5,0.2c0.3-0.1,0.7-0.2,1.1-0.3c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0,0.3c-0.4,0.3-0.7,0.7-0.9,1.1
                                            c-0.1,0.2-0.1,0.4,0.1,0.6c0.1,0,0.1,0.1,0.2,0.1c0.1,0,0.3-0.1,0.3-0.2c0.2-0.3,0.3-0.5,0.5-0.7c0.1,0.1,0.2,0.2,0.3,0.3
                                            c0,0.2,0,0.5,0.1,0.7c0.1,0.3,0.1,0.6,0.3,0.9c0.1,0.2,0.2,0.3,0.4,0.3c0,0,0.1,0,0.1,0c0.1,0,0.1-0.1,0.1-0.1
                                            c0.1-0.1,0.1-0.3,0.1-0.4c0-0.1-0.1-0.2-0.1-0.3c0-0.1-0.1-0.3-0.1-0.4c0-0.1-0.1-0.3-0.1-0.4h0.2c0.1,0,0.2,0,0.3,0
                                            c0.3,0.4,0.7,0.7,1.1,0.9c0.2,0.1,0.4,0.1,0.6-0.1c0.1-0.2,0.1-0.4-0.1-0.6l0,0c-0.3-0.2-0.5-0.3-0.7-0.6c0.1-0.1,0.2-0.2,0.3-0.3
                                            h0.1c0.5,0,1-0.1,1.5-0.3c0.2-0.1,0.3-0.3,0.2-0.5C19.9,16.7,19.7,16.6,19.5,16.6L19.5,16.6z M17.7,16.7L17.7,16.7
                                            c0,0.3-0.1,0.5-0.3,0.7c0,0-0.1,0.1-0.1,0.1c-0.1,0.1-0.3,0.1-0.5,0.1h-0.1c-0.2,0-0.5-0.1-0.6-0.3c0,0-0.1-0.1-0.1-0.1
                                            c-0.1-0.1-0.1-0.3-0.1-0.5c0,0,0,0,0-0.1c0,0,0-0.1,0-0.1c0-0.2,0.1-0.4,0.3-0.5c0,0,0.1-0.1,0.1-0.1c0.1-0.1,0.3-0.1,0.5-0.1h0.1
                                            c0,0,0.1,0,0.1,0c0.2,0,0.4,0.1,0.5,0.3c0,0,0.1,0.1,0.1,0.1C17.6,16.4,17.7,16.6,17.7,16.7L17.7,16.7z"/>
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ __('Turbo Drive') }}</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ __('Turbo Drive accelerates links and form submissions by negating the need for full page reloads.') }}
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-sky-500 dark:stroke-yellow-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="https://turbo.hotwired.dev/reference/frames" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-sky-50 dark:bg-yellow-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-sky-500 dark:stroke-yellow-500">
                                        <path d="M3.1,14.5c-0.6,0-1-0.5-1-1V3.1c0-0.6,0.5-1,1-1h10.3c0.6,0,1,0.5,1,1V13c0.6-0.4,1.3-0.6,2.1-0.6V2.1
                                            c0-1.1-0.9-2.1-2.1-2.1H2.1C0.9,0,0,0.9,0,2.1v12.4c0,1.1,0.9,2.1,2.1,2.1h10.3c0-0.8,0.2-1.5,0.6-2.1H3.1z"/>
                                        <path d="M19.4,16.5c-0.4,0.1-0.7,0.2-1.1,0.3c0-0.1,0-0.3,0-0.4c0.4-0.3,0.7-0.7,1-1.1c0.1-0.2,0.1-0.5-0.1-0.6
                                            c-0.2-0.1-0.5-0.1-0.6,0.1c-0.2,0.3-0.4,0.5-0.6,0.7c-0.1-0.1-0.2-0.3-0.4-0.3c0-0.3,0-0.5-0.1-0.7c-0.1-0.3-0.2-0.7-0.3-1
                                            c-0.1-0.2-0.3-0.3-0.5-0.3c0,0,0,0,0,0c-0.1,0-0.1,0.1-0.2,0.1c-0.1,0.1-0.2,0.3-0.1,0.4c0,0.1,0.1,0.2,0.1,0.3
                                            c0,0.1,0.1,0.3,0.1,0.4c0,0.1,0.1,0.3,0.1,0.4c-0.1,0-0.3,0-0.4,0c-0.3-0.4-0.7-0.7-1.1-1c-0.2-0.1-0.5,0-0.6,0.2
                                            c-0.1,0.2-0.1,0.4,0.1,0.6c0.3,0.2,0.5,0.4,0.8,0.6c-0.1,0.1-0.3,0.2-0.4,0.4c-0.6,0-1.2,0.1-1.7,0.3c-0.2,0.1-0.3,0.3-0.3,0.5
                                            c0.1,0.2,0.3,0.3,0.5,0.3c0.4-0.1,0.7-0.2,1.1-0.3c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0,0.3c-0.4,0.3-0.7,0.7-1,1.1
                                            c-0.1,0.2-0.1,0.5,0.1,0.6c0.1,0,0.1,0.1,0.2,0.1c0.1,0,0.3-0.1,0.4-0.2c0.2-0.3,0.4-0.5,0.6-0.7c0.1,0.1,0.2,0.3,0.4,0.4
                                            c0,0.3,0,0.5,0.1,0.7c0.1,0.3,0.2,0.7,0.3,1c0.1,0.2,0.2,0.3,0.4,0.3c0,0,0.1,0,0.1,0c0.1,0,0.1-0.1,0.2-0.1
                                            c0.1-0.1,0.2-0.3,0.1-0.4c0-0.1-0.1-0.2-0.1-0.3c0-0.1-0.1-0.3-0.1-0.4c0-0.1-0.1-0.3-0.1-0.4h0.2c0.1,0,0.2,0,0.3,0
                                            c0.3,0.4,0.7,0.7,1.1,1c0.2,0.1,0.5,0.1,0.6-0.1c0.1-0.2,0.1-0.5-0.1-0.6l0,0c-0.3-0.2-0.5-0.4-0.7-0.6c0.1-0.1,0.3-0.2,0.4-0.4h0.1
                                            c0.6,0,1.1-0.1,1.6-0.3c0.2-0.1,0.3-0.3,0.2-0.6C19.9,16.5,19.7,16.4,19.4,16.5L19.4,16.5z M17.5,16.6L17.5,16.6
                                            c0,0.3-0.1,0.6-0.3,0.7c0,0-0.1,0.1-0.1,0.1c-0.2,0.1-0.3,0.1-0.5,0.1h-0.1c-0.3,0-0.5-0.1-0.7-0.3c0,0-0.1-0.1-0.1-0.1
                                            c-0.1-0.2-0.1-0.3-0.1-0.5c0,0,0-0.1,0-0.1c0,0,0-0.1,0-0.1c0-0.2,0.2-0.4,0.3-0.5c0,0,0.1-0.1,0.1-0.1c0.2-0.1,0.3-0.1,0.5-0.1h0.1
                                            c0,0,0.1,0,0.1,0c0.2,0,0.4,0.2,0.5,0.3c0,0,0.1,0.1,0.1,0.1C17.5,16.2,17.5,16.4,17.5,16.6L17.5,16.6z"/>
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ __('Turbo Frames') }}</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ __('Turbo Frames decompose pages into independent contexts, which scope navigation and can be lazily loaded.') }}
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-sky-500 dark:stroke-yellow-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="https://turbo.hotwired.dev/reference/streams" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-sky-50 dark:bg-yellow-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-sky-500 dark:stroke-yellow-500">
                                        <path d="M16.9,10.8c0.7,0,1.3,0.2,1.8,0.5c-0.1-0.3-0.3-0.5-0.6-0.6c-0.5-0.2-1.1-0.9-2.5-0.9c-1.8,0-2,0.9-3.1,0.9
                                            c-1.1,0-1.3-0.9-3.1-0.9c-1.8,0-2,0.9-3.1,0.9S5,9.8,3.1,9.8c-1.4,0-2,0.7-2.5,0.9C0.2,10.8,0,11.1,0,11.6c0,0.6,0.6,1.1,1.2,0.9
                                            c1-0.3,1-0.8,1.9-0.8c1.2,0,1.3,0.9,3.1,0.9s2-0.9,3.1-0.9c1.1,0,1.3,0.9,3.1,0.9c0.5,0,0.9-0.1,1.3-0.2
                                            C14.4,11.4,15.6,10.8,16.9,10.8z"/>
                                        <path d="M1.2,5c1-0.3,1-0.8,1.9-0.8c1.1,0,1.3,0.9,3.1,0.9c1.8,0,2-0.9,3.1-0.9c1.1,0,1.3,0.9,3.1,0.9c1.8,0,2-0.9,3.1-0.9
                                            c0.9,0,1,0.4,1.9,0.7c0.6,0.2,1.2-0.2,1.2-0.9c0-0.5-0.2-0.8-0.6-0.9c-0.6-0.2-1.1-0.9-2.5-0.9c-1.8,0-2,0.9-3.1,0.9
                                            c-1.1,0-1.3-0.9-3.1-0.9c-1.8,0-2,0.9-3.1,0.9c-1.1,0-1.3-0.9-3.1-0.9c-1.4,0-2,0.7-2.5,0.9C0.2,3.3,0,3.6,0,4.1
                                            C0,4.7,0.6,5.2,1.2,5z"/>
                                        <path d="M1.2,8.7c1-0.3,1-0.8,1.9-0.8c1.1,0,1.3,0.9,3.1,0.9c1.8,0,2-0.9,3.1-0.9c1.1,0,1.3,0.9,3.1,0.9c1.8,0,2-0.9,3.1-0.9
                                            c0.9,0,1,0.4,1.9,0.7c0.6,0.2,1.2-0.2,1.2-0.9c0-0.5-0.2-0.8-0.6-0.9c-0.6-0.2-1.1-0.8-2.5-0.8c-1.8,0-2,0.9-3.1,0.9
                                            c-1.1,0-1.3-0.9-3.1-0.9C7.5,6.1,7.4,7,6.2,7C5.1,7,4.9,6.1,3.1,6.1c-1.4,0-2,0.7-2.5,0.9C0.2,7.1,0,7.4,0,7.9
                                            C0,8.5,0.6,8.9,1.2,8.7z"/>
                                        <path d="M19.5,14.4c-0.3,0.1-0.7,0.2-1,0.2c0-0.1,0-0.3,0-0.4c0.3-0.3,0.6-0.6,0.9-1c0.1-0.2,0.1-0.4-0.1-0.5s-0.4-0.1-0.5,0.1
                                            c-0.2,0.2-0.3,0.5-0.5,0.7c-0.1-0.1-0.2-0.2-0.3-0.3c0-0.2,0-0.5-0.1-0.7c-0.1-0.3-0.1-0.6-0.2-0.9c-0.1-0.2-0.3-0.3-0.5-0.2
                                            c0,0,0,0,0,0c-0.1,0-0.1,0-0.1,0.1c-0.1,0.1-0.1,0.3-0.1,0.4c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0,0.3,0.1,0.4
                                            c-0.1,0-0.3,0-0.4,0c-0.3-0.3-0.6-0.6-1-0.9c-0.2-0.1-0.4,0-0.5,0.1c-0.1,0.2-0.1,0.4,0.1,0.5c0.2,0.1,0.5,0.3,0.7,0.5
                                            c-0.1,0.1-0.2,0.2-0.3,0.3c-0.5,0-1.1,0.1-1.6,0.3c-0.2,0.1-0.3,0.3-0.2,0.5c0.1,0.2,0.3,0.3,0.5,0.2c0.3-0.1,0.7-0.2,1-0.2
                                            c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0,0.2c-0.3,0.3-0.6,0.6-0.9,1c-0.1,0.2-0.1,0.4,0.1,0.5c0.1,0,0.1,0.1,0.2,0.1
                                            c0.1,0,0.3-0.1,0.3-0.2c0.1-0.2,0.3-0.5,0.5-0.7c0.1,0.1,0.2,0.2,0.3,0.3c0,0.2,0,0.5,0.1,0.7c0.1,0.3,0.1,0.6,0.2,0.9
                                            c0.1,0.1,0.2,0.2,0.4,0.2c0,0,0.1,0,0.1,0c0.1,0,0.1-0.1,0.1-0.1c0.1-0.1,0.1-0.3,0.1-0.4c0-0.1-0.1-0.2-0.1-0.3
                                            c0-0.1-0.1-0.2-0.1-0.3c0-0.1-0.1-0.3-0.1-0.4h0.2c0.1,0,0.2,0,0.2,0c0.3,0.3,0.6,0.6,1,0.9c0.2,0.1,0.4,0.1,0.5-0.1
                                            c0.1-0.2,0.1-0.4-0.1-0.5l0,0c-0.2-0.2-0.5-0.3-0.7-0.5c0.1-0.1,0.2-0.2,0.3-0.3h0.1c0.5,0,1-0.1,1.5-0.3c0.2-0.1,0.3-0.3,0.2-0.5
                                            C19.9,14.5,19.7,14.4,19.5,14.4L19.5,14.4z M17.8,14.5L17.8,14.5c0,0.3-0.1,0.5-0.3,0.7c0,0-0.1,0.1-0.1,0.1
                                            c-0.1,0.1-0.3,0.1-0.5,0.1h-0.1c-0.2,0-0.4-0.1-0.6-0.3c0,0-0.1-0.1-0.1-0.1c-0.1-0.1-0.1-0.3-0.1-0.5c0,0,0,0,0-0.1
                                            c0,0,0-0.1,0-0.1c0-0.2,0.1-0.3,0.3-0.5c0,0,0.1-0.1,0.1-0.1c0.1-0.1,0.3-0.1,0.5-0.1H17c0,0,0.1,0,0.1,0c0.2,0,0.3,0.1,0.5,0.3
                                            c0,0,0.1,0.1,0.1,0.1C17.7,14.2,17.8,14.4,17.8,14.5L17.8,14.5z"/>
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ __('Turbo Streams') }}</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ __('Turbo Streams deliver page changes over WebSocket, SSE or in response to form submissions using just HTML and a set of CRUD-like actions.') }}
                                </p>
                            </div>


                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-sky-500 dark:stroke-yellow-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="https://turbo.hotwired.dev/handbook/native" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-sky-50 dark:bg-yellow-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-sky-500 dark:stroke-yellow-500">
                                        <path d="M11.6,17c0-0.3,0.1-0.6,0.1-0.9H3.6V3.6h9v11.1c0.5-0.5,1.1-0.9,1.8-1.1V1.8c0-1-0.8-1.8-1.8-1.8l-9,0c-1,0-1.8,0.8-1.8,1.8
                                            v16.1c0,1,0.8,1.8,1.8,1.8h9c0.1,0,0.2,0,0.3,0C12.1,19,11.6,18.1,11.6,17z"/>
                                        <path d="M17.7,16.9c-0.3,0.1-0.6,0.2-1,0.2c0-0.1,0-0.3,0-0.4c0.3-0.3,0.6-0.6,0.8-1c0.1-0.2,0.1-0.4-0.1-0.5
                                            c-0.2-0.1-0.4-0.1-0.5,0.1c-0.1,0.2-0.3,0.5-0.5,0.6c-0.1-0.1-0.2-0.2-0.3-0.3c0-0.2,0-0.4-0.1-0.6c-0.1-0.3-0.1-0.6-0.2-0.8
                                            c-0.1-0.2-0.3-0.3-0.5-0.2c0,0,0,0,0,0c-0.1,0-0.1,0-0.1,0.1c-0.1,0.1-0.1,0.3-0.1,0.4c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0.1,0.2,0.1,0.3
                                            c0,0.1,0,0.3,0.1,0.4c-0.1,0-0.3,0-0.4,0c-0.3-0.3-0.6-0.6-1-0.8c-0.2-0.1-0.4,0-0.5,0.1c-0.1,0.2,0,0.4,0.1,0.5
                                            c0.2,0.1,0.5,0.3,0.7,0.5c-0.1,0.1-0.2,0.2-0.3,0.3c-0.5,0-1,0.1-1.5,0.3c-0.2,0.1-0.3,0.3-0.2,0.5c0.1,0.2,0.3,0.3,0.5,0.2
                                            c0.3-0.1,0.6-0.2,1-0.2c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0,0.2c-0.3,0.3-0.6,0.6-0.8,1c-0.1,0.2-0.1,0.4,0.1,0.5
                                            c0.1,0,0.1,0.1,0.2,0.1c0.1,0,0.2-0.1,0.3-0.2c0.1-0.2,0.3-0.5,0.5-0.6c0.1,0.1,0.2,0.2,0.3,0.3c0,0.2,0,0.4,0.1,0.6
                                            c0.1,0.3,0.1,0.6,0.2,0.8c0.1,0.1,0.2,0.2,0.3,0.2c0,0,0.1,0,0.1,0c0.1,0,0.1,0,0.1-0.1c0.1-0.1,0.1-0.3,0.1-0.4
                                            c0-0.1-0.1-0.2-0.1-0.3c0-0.1-0.1-0.2-0.1-0.3c0-0.1,0-0.2-0.1-0.4h0.2c0.1,0,0.2,0,0.2,0c0.3,0.3,0.6,0.6,1,0.8
                                            c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.2,0.1-0.4-0.1-0.5l0,0c-0.2-0.1-0.5-0.3-0.6-0.5c0.1-0.1,0.2-0.2,0.3-0.3h0.1c0.5,0,1-0.1,1.4-0.3
                                            c0.2-0.1,0.3-0.3,0.2-0.5C18.1,17,17.9,16.9,17.7,16.9L17.7,16.9z M16.1,17L16.1,17c0,0.3-0.1,0.5-0.3,0.6c0,0-0.1,0.1-0.1,0.1
                                            c-0.1,0.1-0.3,0.1-0.4,0.1h-0.1c-0.2,0-0.4-0.1-0.6-0.3c0,0-0.1-0.1-0.1-0.1c-0.1-0.1-0.1-0.3-0.1-0.4c0,0,0,0,0-0.1
                                            c0,0,0-0.1,0-0.1c0-0.2,0.1-0.3,0.3-0.4c0,0,0.1-0.1,0.1-0.1c0.1-0.1,0.3-0.1,0.4-0.1h0.1c0,0,0.1,0,0.1,0c0.2,0,0.3,0.1,0.4,0.3
                                            c0,0,0.1,0.1,0.1,0.1C16,16.7,16.1,16.9,16.1,17L16.1,17z"/>
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ __('Turbo Native') }}</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ __('Turbo Native lets your majestic monolith form the center of your native iOS and Android apps, with seamless transitions between web and native sections.') }}
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-sky-500 dark:stroke-yellow-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                        <div class="flex items-center gap-4">
                            <a href="https://github.com/sponsors/taylorotwell" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                Sponsor
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
