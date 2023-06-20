<div class="flex items-center justify-between">
    <div class="flex items-center">
        <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
        <div class="ml-4 dark:text-white">{{ $user->name }}</div>
    </div>

    <div class="flex items-center">
        <!-- Manage Team Member Role -->
        @if ($user->is($team->owner))
            <div class="ml-2 text-sm text-gray-400">
                {{ __('Owner') }}
            </div>
        @elseif (Gate::check('updateTeamMember', $team) && HotwiringLaravel\Hotstream\Hotstream::hasRoles())
            <a href="{{ route('teams.team-users.role.edit', [$team, $user]) }}" class="ml-2 text-sm text-gray-400 underline">
                {{ HotwiringLaravel\Hotstream\Hotstream::findRole($user->membership->role)->name }}
            </a>
        @elseif (HotwiringLaravel\Hotstream\Hotstream::hasRoles())
            <div class="ml-2 text-sm text-gray-400">
                {{ HotwiringLaravel\Hotstream\Hotstream::findRole($user->membership->role)->name }}
            </div>
        @endif

        <!-- Leave Team -->
        @unless ($team->owner->is($user))
            @if (auth()->user()->id === $user->id)
                <form action="{{ route('teams.team-users.destroy', [$team, $user]) }}" method="POST" data-turbo-confirm="{{ __('Are you sure you want to leave this team?') }}">
                    @csrf
                    @method('DELETE')

                    <button class="cursor-pointer ml-6 text-sm text-red-500">
                        {{ __('Leave') }}
                    </button>
                </form>

            <!-- Remove Team Member -->
            @elseif (Gate::check('removeTeamMember', $team))
                <form action="{{ route('teams.team-users.destroy', [$team, $user]) }}" method="POST" data-turbo-confirm="{{ __('Are you sure you want to remove this user from the team?') }}">
                    @csrf
                    @method('DELETE')

                    <button class="cursor-pointer ml-6 text-sm text-red-500">
                        {{ __('Remove') }}
                    </button>
                </form>
            @endif
        @endunless
    </div>
</div>
