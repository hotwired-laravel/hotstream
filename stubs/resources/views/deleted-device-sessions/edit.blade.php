<x-app-layout :title="__('Logging Out Of Other Sessions')">
    <x-container>
        <x-back-link :href="route('device-sessions.index')" :only-visible-in-frame="false">
            {{ __('Devices & Sessions') }}
        </x-back-link>

        <x-page-heading>{{ __('Logging Out Of Other Sessions') }}</x-page-heading>

        <x-form-card>
            <div class="max-w-xl text-center text-gray-800 dark:text-gray-400">
                {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}
            </div>

            <form class="mt-4" action="{{ route('deleted-device-sessions.update') }}" method="POST">
                @csrf
                @method('PUT')

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
                    <x-button>
                        {{ __('Log Out Other Browser Sessions') }}
                    </x-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
