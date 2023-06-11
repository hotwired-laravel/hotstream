@props(['active'])

<a {{ $attributes->merge(['class' => "inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 is-selected:border-indigo-400 is-selected:dark:border-yellow-600 is-selected:text-gray-900 is-selected:dark:text-gray-100 is-selected:focus:outline-none is-selected:focus:border-indigo-700 is-selected:focus:dark:border-yellow-700"]) }}>
    {{ $slot }}
</a>
