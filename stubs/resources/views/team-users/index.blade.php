<x-app-layout :title="__('Members of :name', ['name' => $team->name])">
    <x-container>
        <x-back-link :href="route('teams.show', $team)">{{ __('Settings for :name', ['name' => $team->name]) }}</x-back-link>

        <x-page-heading>{{ __('Members of :name', ['name' => $team->name]) }}</x-page-heading>

        <x-card-section size="lg">
            <div class="space-y-4">
                @if (Gate::allows('addTeamMember', $team))
                <div class="flex items-center justify-end space-x-4">
                    @if ($team->teamInvitations->isNotEmpty())
                        <a class="text-sm underline transition dark:text-gray-500 dark:hover:text-gray-400" href="{{ route('team-invitations.index', $team)}}">
                            {{ trans_choice('{1} :value pending invitation|[2,*] :value pending invitations', $team->teamInvitations->count(), ['value' => $team->teamInvitations->count()]) }}
                        </a>
                    @endif
                    <x-button-link :href="route('team-invitations.create', ['team' => $team->id, 'redirect_to' => 'members'])" class="flex items-center space-x-2">
                        {{ __('Invite Someone') }}
                    </x-button-link>
                </div>
                @endif

                <div class="space-y-6">
                    @include('team-users._team_user', [
                        'user' => $team->owner,
                        'team' => $team,
                    ])

                    @foreach ($team->users->sortBy('name') as $user)
                        @include('team-users._team_user', [
                            'user' => $user,
                            'team' => $team,
                        ])
                    @endforeach
                </div>
            </div>
        </x-card-section>
    </x-container>
</x-app-layout>
