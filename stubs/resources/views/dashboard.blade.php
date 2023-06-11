<x-app-layout :title="__('Dashboard')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-container size="lg">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl">
            <x-welcome />
        </div>
    </x-container>
</x-app-layout>
