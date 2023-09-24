<x-app-layout :title="__('Deleting Account')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Deleting Account') }}</x-page-heading>

        <x-form-card>
            <p class="mb-6 text-center text-gray-800 dark:text-gray-400">
                {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf

                <div>
                    <x-input type="password" class="block w-full mt-1"
                                name="password"
                                autofocus
                                autocomplete="current-password"
                                placeholder="{{ __('Password') }}"
                                required />

                    <x-input-error for="password" class="mt-2" />
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-danger-button type="submit" class="ml-4">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
