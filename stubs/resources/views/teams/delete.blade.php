<x-app-layout :title="__('Deleting Team :name', ['name' => $team->name])">
    <x-container>
        <x-back-link :href="route('teams.show', $team)">{{ __('Deleting Team :name', ['name' => $team->name]) }}</x-back-link>

        <x-page-heading>{{ __('Deleting Team :name', ['name' => $team->name]) }}</x-page-heading>

        <x-form-card>
            <p class="mb-6 dark:text-gray-400">
                {{ __('Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.') }}
            </p>

            <form method="POST" action="{{ route('teams.destroy', $team) }}">
                @csrf
                @method('DELETE')

                <div class="flex items-center justify-end mt-4">
                    <x-danger-button type="submit" class="ml-4">
                        {{ __('Delete Team') }}
                    </x-danger-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
