<x-app-layout :title="__('Enabling Two Factor Authentication')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Enabling Two Factor Authentication') }}</x-page-heading>

        <x-card-section size="lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Finish enabling two factor authentication.') }}
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                <p>
                    {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                </p>
            </div>

            <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                <p class="font-semibold">
                    {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                </p>
            </div>

            <div class="mt-4 p-2 inline-block bg-white">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>

            <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                <p class="font-semibold">
                    {{ __('Setup Key') }}: {{ decrypt(auth()->user()->two_factor_secret) }}
                </p>
            </div>

            <form action="{{ route('confirmed-two-factor-authentication.store') }}" method="POST" class="mt-4">
                @csrf

                <div>
                    <x-label for="code" value="{{ __('Code') }}" />
                    <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code" />
                    <x-input-error for="code" bag="confirmTwoFactorAuthentication" class="mt-2" />
                </div>

                <div class="mt-5 flex items-center space-x-4">
                    <x-button type="submit">{{ __('Confirm') }}</x-button>

                    <x-secondary-button-link :href="route('two-factor-authentication.index')">
                        {{ __('Cancel') }}
                    </x-secondary-button-link>
                </div>
            </form>
        </x-card-section>
    </x-container>
</x-app-layout>
