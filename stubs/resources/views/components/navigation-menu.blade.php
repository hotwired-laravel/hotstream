<nav data-controller="main-nav" data-action="turbo:load@window->main-nav#higlightCurrentNavLink" data-main-nav-selected-class="is-selected" id="navigation" data-turbo-permanent class="bg-white shadow native:hidden dark:bg-gray-800 dark:border-gray-700">
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
                            @if (HotwiringLaravel\Hotstream\Hotstream::managesProfilePhotos())
                                <a data-turbo-frame="navigation-menu" href="{{ route('accounts.index') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    @include('profile._current_user_nav_photo', ['id' => 'current-user-nav-photo', 'user' => Auth::user()])
                                </a>
                            @else
                                <span class="inline-flex rounded-md">
                                    <a data-turbo-frame="navigation-menu" href="{{ route('accounts.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
                                        {{ Auth::user()->name }}
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
            <div class="flex items-center space-x-2 sm:hidden">
                <x-dropdown width="44">
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                                <span class="sr-only">{{ __('Page Menu') }}</span>
                                <x-icon icon="bars-3"></x-icon>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content">
                        <x-responsive-nav-link data-action="dropdown#close" href="{{ route('dashboard') }}" data-main-nav-target="link" data-nav-pattern="/dashboard">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    </x-slot>
                </x-dropdown>

                @if (HotwiringLaravel\Hotstream\Hotstream::managesProfilePhotos())
                    <a href="{{ route('accounts.index') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                        @include('profile._current_user_nav_photo', ['id' => 'current-user-nav-photo', 'user' => Auth::user()])
                    </a>
                @else
                    <span class="inline-flex rounded-md">
                        <a href="{{ route('accounts.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                            {{ Auth::user()->name }}
                        </a>
                    </span>
                @endif
            </div>
        </div>
    </div>
</nav>
