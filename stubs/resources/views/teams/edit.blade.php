<x-app-layout :title="__('Edit Team')">
    <x-container>
        <x-back-link :href="route('teams.show', $team)">{{ __('Settings for :name', ['name' => $team->name]) }}</x-back-link>

        <x-page-heading>{{ __('Editing Team') }}</x-page-heading>

        <x-form-card>
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('teams.update', $team) }}">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="name" value="{{ __('Team Name') }}" />
                    <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name', $team->name)" placeholder="{{ __('Acme Inc.') }}" required autofocus autocomplete="teamname" />
                    <x-input-error for="name" class="mt-2" />
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
