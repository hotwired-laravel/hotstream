<x-app-layout :title="__('Two Factor Authentication')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Two Factor Authentication') }}</x-page-heading>

        <x-card-section>
            <h3 class="text-lg font-medium text-center text-gray-900 dark:text-gray-100">
                @if (auth()->user()->hasEnabledTwoFactorAuthentication())
                    {{ __('You have enabled two factor authentication.') }}
                @else
                    {{ __('You have not enabled two factor authentication.') }}
                @endif
            </h3>

            <div class="max-w-xl mt-3 text-center text-gray-800 dark:text-gray-400">
                <p>
                    {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                </p>
            </div>

            <div class="mt-5">
                @if (auth()->user()->hasEnabledTwoFactorAuthentication())
                    <turbo-frame
                        id="recovery-codes"
                        class="contents"
                        @if (session('showRecoveryCodes'))
                        src="{{ route('recovery-codes.index')}}"
                        data-controller="attribute-removal content-removal"
                        data-attribute-removal-attribute-value="src"
                        data-action="turbo:frame-load->frame-src-removal#remove"
                        @endif
                    >
                        <div class="flex items-center justify-center space-x-4">
                            <x-secondary-button-link id="show-recovery-code-button" data-turbo-frame="recovery-codes" :href="route('recovery-codes.index')">{{ __('Show Recovery Codes') }}</x-secondary-button-link>

                            <form action="{{ route('two-factor-authentication.destroy') }}" method="POST" data-turbo-frame="_top" data-turbo-confirm="{{ __('Are you sure you want to to this?') }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Disable') }}</x-danger-button>
                            </form>
                        </div>
                    </turbo-frame>
                @else
                    <form class="flex items-center justify-center" action="{{ route('enabled-two-factor-authentication.store') }}" method="POST">
                        @csrf
                        <x-button type="submit">{{ __('Enable') }}</x-button>
                    </form>
                @endif
            </div>
        </x-card-section>
    </x-container>
</x-app-layout>
