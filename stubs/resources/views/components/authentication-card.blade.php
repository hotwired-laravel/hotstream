<div class="px-4 sm:px-0 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 md:bg-gray-100 md:dark:bg-gray-900">
    <div class="mb-6 flex items-center justify-center">
        {{ $logo }}
    </div>

    @isset ($heading)
    {{ $heading }}
    @endisset

    <div class="w-full sm:max-w-md md:px-6 md:py-4 md:bg-white md:dark:bg-gray-800 md:shadow-md">
        {{ $slot }}
    </div>
</div>
