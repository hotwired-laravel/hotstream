<nav data-controller="main-nav reveal" data-reveal-toggle-current-element-value="false" data-action="turbo:load@window->main-nav#higlightCurrentNavLink" data-main-nav-selected-class="is-selected" id="navigation" data-turbo-permanent class="bg-white shadow native:hidden dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block w-auto h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" data-main-nav-target="link" data-nav-pattern="/dashboard">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown>
                        <x-slot name="trigger">
                            @if (HotwiredLaravel\Hotstream\Hotstream::managesProfilePhotos())
                                <a data-turbo-frame="navigation-menu" href="{{ route('accounts.index') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    @include('profile._current_user_nav_photo', ['id' => 'current-user-nav-photo', 'user' => Auth::user()])
                                </a>
                            @else
                                <span class="inline-flex rounded-md">
                                    <a data-turbo-frame="navigation-menu" href="{{ route('accounts.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </a>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            @if (request()->header('Turbo-Frame') !== 'navigation-menu')
                            <x-turbo-frame id="navigation-menu" class="in-frame">
                                <p class="p-2 text-sm text-center text-gray-700 animate-pulse dark:text-white">{{ __('Loading...') }}</p>
                            </x-turbo-frame>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button data-action="reveal#toggle" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path data-reveal-target="hiddenWhenShown" data-reveal-shown="inline-flex" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path data-reveal-target="visibleWhenShown" data-reveal-shown="inline-flex" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                @if (HotwiredLaravel\Hotstream\Hotstream::managesProfilePhotos())
                    <a href="{{ route('accounts.index') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                        @include('profile._current_user_nav_photo', ['id' => 'current-user-nav-photo', 'user' => Auth::user()])
                    </a>
                @else
                    <span class="inline-flex rounded-md">
                        <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div data-reveal-target="visibleWhenShown" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" data-main-nav-target="link" data-nav-pattern="/dashboard">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
