<x-app-layout :title="__('Token :name', ['name' => $token->name])">
    <x-container>
        <x-back-link :href="route('api-tokens.index')">
            {{ __('API Tokens') }}
        </x-back-link>

        <x-page-heading>{{ __('Token :name', ['name' => $token->name]) }}</x-page-heading>

        <x-card-section size="lg">
            @include('api-tokens._temporary_access_token')

            <div>
                <p class="text-gray-600 dark:text-gray-400">{{ __('Permissions assigned to this token:') }}</p>
                <ul class="mt-2 list-disc list-inside dark:text-white">
                    @foreach ($token->abilities as $permission)
                    <li>{{ $permission }}</li>
                    @endforeach
                </ul>
            </div>
        </x-card-section>
    </x-container>
</x-app-layout>
