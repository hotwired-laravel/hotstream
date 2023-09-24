<x-app-layout :title="__('Change Password')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Change Password') }}</x-page-heading>

        <x-form-card>
            <p class="mb-6 text-center text-gray-800 native:hidden dark:text-gray-400">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="current_password" value="{{ __('Current Password') }}" />
                    <x-input id="current_password" class="block w-full mt-1" type="password" name="current_password" required autofocus autocomplete="off" />
                    <x-input-error for="current_password" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('New Password') }}" />
                    <x-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="off" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="off" />
                    <x-input-error for="password_confirmation" class="mt-2" />
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-button class="ml-4">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
