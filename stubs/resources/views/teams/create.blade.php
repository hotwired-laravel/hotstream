<x-app-layout :title="__('Create Team')">
    <x-container>
        <x-back-link :href="route('accounts.index')">{{ __('Teams & Settings') }}</x-back-link>

        <x-page-heading>{{ __('Create Team') }}</x-page-heading>

        <x-form-card>
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('teams.store') }}">
                @csrf

                <div>
                    <x-label for="name" value="{{ __('Team Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="{{ __('Acme Inc.') }}" required autofocus autocomplete="teamname" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
