<x-guest-layout :title="__('Two Factor Challenge')">
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-slot name="heading">
            <x-page-heading>
                {{ __('Two Factor Challenge') }}
            </x-page-heading>
        </x-slot>

        <div
            data-controller="grouped-reveal focus clear-fields"
            data-grouped-reveal-toggle-class="hidden"
            data-grouped-reveal-initial-value="code"
        >
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" data-grouped-reveal-target="reveal" data-reveal-group="code">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 hidden" data-grouped-reveal-target="reveal" data-reveal-group="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4" data-grouped-reveal-target="reveal" data-reveal-group="code">
                    <x-label for="code" value="{{ __('Code') }}" />
                    <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus autocomplete="one-time-code" />
                </div>

                <div class="mt-4 hidden" data-grouped-reveal-target="reveal" data-reveal-group="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                    <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button
                        type="button"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 underline cursor-pointer"
                        data-action="grouped-reveal#toggle focus#focusNextTick"
                        data-focus-target="#recovery_code"
                        data-grouped-reveal-target="reveal"
                        data-reveal-group="code"
                        data-reveal-group-toggle="recovery"
                    >
                        {{ __('Use a recovery code') }}
                    </button>

                    <button
                        type="button"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 underline cursor-pointer hidden"
                        data-action="grouped-reveal#toggle focus#focusNextTick"
                        data-focus-target="#code"
                        data-grouped-reveal-target="reveal"
                        data-reveal-group="recovery"
                        data-reveal-group-toggle="code"
                    >
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="ml-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
