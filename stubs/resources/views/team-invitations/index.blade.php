<x-app-layout :title="__('Pending Invitations')">
    <x-container>
        <x-back-link :href="route('team-users.index', $team)" :only-visible-in-frame="false">
            {{ __('Members of :name', ['name' => $team->name]) }}
        </x-back-link>

        <x-page-heading>{{ __('Pending Invitations') }}</x-page-heading>

        <x-card-section>
            <div class="space-y-4">
                @if (count($team->teamInvitations) === 0)
                <div class="hidden only:block">
                    <p class="text-center text-gray-500">{{ __('No pending invitations.') }}</p>
                </div>
                @endif

                @foreach ($team->teamInvitations as $invitation)
                    <div class="flex items-center justify-between">
                        <div class="text-gray-600 dark:text-gray-400">{{ $invitation->email }}</div>

                        <div class="flex items-center">
                            @if (Gate::check('removeTeamMember', $team))
                                <!-- Cancel Team Invitation -->
                                <form action="{{ route('team-invitations.destroy', $invitation) }}" method="POST" data-turbo-confirm="{{ __('Are you sure you want to delete this invitation?') }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="ml-6 text-sm text-red-500 cursor-pointer focus:outline-none">
                                        {{ __('Cancel') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card-section>
    </x-container>
</x-app-layout>
