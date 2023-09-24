<x-app-layout :title="__('Recovery Codes')">
    <x-container>
        <x-back-link :href="route('two-factor-authentication.index')">
            {{ __('Two Factor Authentication') }}
        </x-back-link>

        <x-page-heading>{{ __('Recovery Codes') }}</x-page-heading>

        <x-card-section size="lg">
            <turbo-frame id="recovery-codes" class="contents">
                <div class="max-w-xl mt-4 text-center text-gray-800 dark:text-gray-400" data-turbo-temporary>
                    <p class="font-semibold">
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>
                </div>

                <div class="grid max-w-xl gap-1 px-4 py-4 mt-4 font-mono text-sm bg-gray-100 rounded-lg" data-turbo-temporary>
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        <div class="text-center">{{ $code }}</div>
                    @endforeach
                </div>

                <div class="mt-4 space-x-0 space-y-4 md:flex md:items-center md:space-y-0 md:space-x-4">
                    <form action="{{ route('recovery-codes.store') }}" method="POST">
                        @csrf
                        <x-secondary-button type="submit">{{ __('Regenerate Recovery Codes') }}</x-secondary-button>
                    </form>

                    <form action="{{ route('two-factor-authentication.destroy') }}" method="POST" data-turbo-frame="_top" data-turbo-confirm="{{ __('Are you sure you want to to this?') }}">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">{{ __('Disable') }}</x-danger-button>
                    </form>
                </div>
            </turbo-frame>
        </x-card-section>
    </x-container>
</x-app-layout>
